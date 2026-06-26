<?php

namespace App\Modules\Purchases\Services;

use App\Core\Database;
use App\Modules\Purchases\Repositories\PurchaseRepository;
use App\Modules\Inventory\Services\InventoryService;

use PDO;
use Exception;

class PurchaseService
{
    protected PurchaseRepository $repository;
    protected InventoryService $inventory;
    protected PDO $db;

    public function __construct()
    {
        $this->repository =
            new PurchaseRepository();

        $this->inventory =
            new InventoryService();

        $this->db =
            Database::connect();
    }

    /**
     * ---------------------------------------------------------
     * Create Purchase
     * ---------------------------------------------------------
     */
    public function create(
        array $data
    ): bool {

        try {

            $this->db->beginTransaction();

            /**
             * Purchase
             */
            $created =
                $this->repository
                    ->createPurchase([
                        'purchase_number' =>
                            $this->repository
                                ->generatePurchaseNumber(),

                        'supplier_id' =>
                            $data['supplier_id'],

                        'subtotal' =>
                            $data['subtotal'],

                        'tax' =>
                            $data['tax'],

                        'discount' =>
                            $data['discount'],

                        'total' =>
                            $data['total'],

                        'payment_status' =>
                            $data['payment_status']
                            ?? 'pending',

                        'order_status' =>
                            'completed'
                    ]);

            if (!$created) {
                throw new Exception(
                    'Purchase creation failed'
                );
            }

            /**
             * Purchase ID
             */
            $purchaseId =
                (int) $this->db->lastInsertId();

            /**
             * Items
             */
            foreach (
                ($data['items'] ?? [])
                as $item
            ) {

                $saved =
                    $this->repository
                        ->createItem([

                            'purchase_id' =>
                                $purchaseId,

                            'product_id' =>
                                $item['product_id'],

                            'quantity' =>
                                $item['quantity'],

                            'unit_cost' =>
                                $item['unit_cost'],

                            'total_cost' =>
                                $item['quantity']
                                * $item['unit_cost'],

                            'expiry_date' =>
                                $item['expiry_date']
                                ?? null,

                            'batch_number' =>
                                $item['batch_number']
                                ?? null
                        ]);

                if (!$saved) {
                    throw new Exception(
                        'Purchase item failed'
                    );
                }

                /**
                 * Inventory Batch
                 */
                $received =
                    $this->inventory
                        ->receiveStock([

                            'product_id' =>
                                $item['product_id'],

                            'batch_number' =>
                                $item['batch_number']
                                ?? null,

                            'expiry_date' =>
                                $item['expiry_date']
                                ?? null,

                            'quantity' =>
                                $item['quantity'],

                            'supplier' =>
                                null,

                            'supplier_id' =>
                                $data['supplier_id'] ?? null,

                            'purchase_price' =>
                                $item['unit_cost'],

                            'selling_price' =>
                                0,

                            'minimum_stock_level' =>
                                $item['minimum_stock_level'] ?? 5
                        ]);

                if (!$received) {
                    throw new Exception(
                        'Inventory batch failed'
                    );
                }
            }

            $this->db->commit();

            return true;

        } catch (Exception $e) {

            $this->db->rollBack();

            return false;
        }
    }

    /**
     * Purchase History
     */
    public function history(): array
    {
        return $this->repository
            ->allPurchases();
    }

    /**
     * ---------------------------------------------------------
     * Cancel Purchase
     * ---------------------------------------------------------
     * Safely restores inventory consistency
     */
    public function cancel(int $purchaseId): bool
    {
        try {
            $this->db->beginTransaction();

            // Get purchase details
            $purchase = $this->repository->find($purchaseId);

            if (!$purchase) {
                throw new Exception('Purchase not found');
            }

            if ($purchase['order_status'] === 'cancelled') {
                throw new Exception('Purchase already cancelled');
            }

            // Get purchase items to know which batches to remove
            $items = $this->repository->getItems($purchaseId);

            foreach ($items as $item) {
                // Find the batch created by this purchase
                $batchStmt = $this->db->prepare(
                    "SELECT id, quantity FROM inventory_batches 
                     WHERE product_id = :product_id 
                     AND batch_number = :batch_number 
                     AND expiry_date = :expiry_date
                     ORDER BY id DESC LIMIT 1"
                );
                $batchStmt->execute([
                    'product_id' => $item['product_id'],
                    'batch_number' => $item['batch_number'] ?? '',
                    'expiry_date' => $item['expiry_date'] ?? ''
                ]);
                $batch = $batchStmt->fetch(PDO::FETCH_ASSOC);

                if ($batch) {
                    // Only cancel if the batch hasn't been partially consumed
                    // If quantity is less than the original purchase quantity, 
                    // some stock has already been sold
                    $originalQty = (int) $item['quantity'];
                    $currentQty = (int) $batch['quantity'];

                    if ($currentQty < $originalQty) {
                        throw new Exception(
                            'Cannot cancel purchase: batch #' . $batch['id'] . 
                            ' has been partially consumed (' . $currentQty . 
                            ' remaining of ' . $originalQty . ')'
                        );
                    }

                    // Create reversal movement log
                    $this->inventory->createMovement([
                        'product_id' => $item['product_id'],
                        'batch_id' => $batch['id'],
                        'movement_type' => 'purchase_cancellation',
                        'quantity' => $currentQty,
                        'notes' => 'Purchase cancelled #' . $purchase['purchase_number']
                    ]);

                    // Delete the batch
                    $deleteStmt = $this->db->prepare(
                        "DELETE FROM inventory_batches WHERE id = :id"
                    );
                    $deleteStmt->execute(['id' => $batch['id']]);
                }
            }

            // Decrement supplier purchase stats
            if (!empty($purchase['supplier_id'])) {
                $updateSupplier = $this->db->prepare(
                    "UPDATE suppliers 
                     SET total_purchases = GREATEST(COALESCE(total_purchases, 1) - 1, 0)
                     WHERE id = :supplier_id"
                );
                $updateSupplier->execute([
                    'supplier_id' => $purchase['supplier_id']
                ]);
            }

            // Mark purchase as cancelled
            $updatePurchase = $this->db->prepare(
                "UPDATE purchases SET order_status = 'cancelled', payment_status = 'cancelled' WHERE id = :id"
            );
            $updatePurchase->execute(['id' => $purchaseId]);

            $this->db->commit();

            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

}
