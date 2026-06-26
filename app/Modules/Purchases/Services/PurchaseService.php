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

                            'purchase_price' =>
                                $item['unit_cost'],

                            'selling_price' =>
                                0
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
            ->history();
    }

}