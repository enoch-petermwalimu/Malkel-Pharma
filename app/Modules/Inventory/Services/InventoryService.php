<?php

namespace App\Modules\Inventory\Services;

use App\Modules\Inventory\Models\InventoryBatch;
use App\Modules\Inventory\Models\StockMovement;
use App\Core\Database;
use PDO;
use Exception;

/**
 * =============================================================
 * Inventory Service
 * =============================================================
 * Real stock engine
 * Batch-based inventory
 * FEFO-ready
 * =============================================================
 */
class InventoryService
{
    protected InventoryBatch $batchModel;
    protected StockMovement $movementModel;
    protected PDO $db;

    public function __construct()
    {
        $this->batchModel = new InventoryBatch();
        $this->movementModel = new StockMovement();
        $this->db = Database::connect();
    }

    /**
     * ---------------------------------------------------------
     * Create movement log
     * ---------------------------------------------------------
     */
    public function adjustPhysicalCount(array $data): bool
{
    try {
        $this->db->beginTransaction();

        $statement = $this->db->prepare(
            "
            SELECT *
            FROM inventory_batches
            WHERE id = :batch_id
            LIMIT 1
            "
        );

        $statement->execute([
            'batch_id' => $data['batch_id']
        ]);

        $batch =
            $statement->fetch(PDO::FETCH_ASSOC);

        if (!$batch) {
            throw new Exception('Batch not found');
        }

        $systemQty =
            (int) $batch['quantity'];

        $physicalQty =
            (int) $data['physical_quantity'];

        $difference =
            $physicalQty - $systemQty;

        /**
         * Update actual stock
         */
        $update = $this->db->prepare(
            "
            UPDATE inventory_batches
            SET quantity = :qty
            WHERE id = :id
            "
        );

        $update->execute([
            'qty' => $physicalQty,
            'id' => $data['batch_id']
        ]);

        /**
         * Audit adjustment
         */
        $adjustment =
            new \App\Modules\Inventory\Models\StockAdjustment();

        $adjustment->create([
            'product_id' =>
                $batch['product_id'],

            'batch_id' =>
                $data['batch_id'],

            'adjustment_type' =>
                $difference >= 0
                    ? 'adjustment_positive'
                    : 'adjustment_negative',

            'system_quantity' =>
                $systemQty,

            'physical_quantity' =>
                $physicalQty,

            'difference_quantity' =>
                $difference,

            'reason' =>
                $data['reason'],

            'adjusted_by' =>
                $data['user_id'] ?? null
        ]);

        /**
         * Movement log
         */
        $this->createMovement([
            'product_id' =>
                $batch['product_id'],

            'batch_id' =>
                $data['batch_id'],

            'movement_type' =>
                $difference >= 0
                    ? 'adjustment_positive'
                    : 'adjustment_negative',

            'quantity' =>
                abs($difference),

            'notes' =>
                $data['reason']
        ]);

        $this->db->commit();

        return true;

    } catch (Exception $e) {

        $this->db->rollBack();

        return false;
    }
}
    public function createMovement(array $data): bool
    {
        return $this->movementModel->create([
            'product_id' => $data['product_id'],
            'batch_id' => $data['batch_id'] ?? null,
            'movement_type' => $data['movement_type'],
            'quantity' => $data['quantity'],
            'notes' => $data['notes'] ?? null
        ]);
    }

    /**
     * ---------------------------------------------------------
     * Receive stock (purchase)
     * Creates a new batch
     * ---------------------------------------------------------
     */
    public function receiveStock(array $data): bool
    {
        try {

            $this->db->beginTransaction();

            $created = $this->batchModel->create([

                'product_id'     => $data['product_id'],

                'batch_number'   => $data['batch_number'],

                'expiry_date'    => $data['expiry_date'],

                'quantity'       => $data['quantity'],

                'supplier'       => $data['supplier'] ?? null,

                'purchase_price' => $data['purchase_price'] ?? 0,

                'selling_price'  => $data['selling_price'] ?? 0,

                'received_at'    => date('Y-m-d H:i:s')

            ]);

            if (!$created) {
                throw new Exception(
                    'Batch creation failed'
                );
            }

            $batchId =
                (int) $this->db->lastInsertId();

            $updateProduct =
                $this->db->prepare(
                    "
                    UPDATE products
                    SET
                        purchase_price = :purchase_price,
                        selling_price = :selling_price
                    WHERE id = :product_id
                    "
                );

            $updateProduct->execute([

                'purchase_price' =>
                    $data['purchase_price'],

                'selling_price' =>
                    $data['selling_price'],

                'product_id' =>
                    $data['product_id']
            ]);
            $this->createMovement([
                'product_id' => $data['product_id'],
                'batch_id'   => $batchId,
                'movement_type' => 'purchase',
                'quantity'   => $data['quantity'],
                'notes'      => 'Stock received'
            ]);

            $this->db->commit();

            return true;

        } catch (Exception $e) {

            $this->db->rollBack();

            return false;
        }
    }

    /**
     * ---------------------------------------------------------
     * FEFO deduction
     * ---------------------------------------------------------
     */
    public function deductStock(
        int $productId,
        int $requestedQty
    ): bool {
        try {
            $this->db->beginTransaction();

            /**
             * Get eligible batches
             * FEFO = earliest expiry first
             */
            $statement = $this->db->prepare(
                "
                SELECT *
                FROM inventory_batches
                WHERE
                    product_id = :product_id
                    AND quantity > 0
                    AND expiry_date >= CURDATE()
                ORDER BY expiry_date ASC
                "
            );

            $statement->execute([
                'product_id' => $productId
            ]);

            $batches =
                $statement->fetchAll(PDO::FETCH_ASSOC);

            $remaining = $requestedQty;

            foreach ($batches as $batch) {

                if ($remaining <= 0) {
                    break;
                }

                $available =
                    (int) $batch['quantity'];

                $deduct =
                    min($available, $remaining);

                /**
                 * Update batch qty
                 */
                $update = $this->db->prepare(
                    "
                    UPDATE inventory_batches
                    SET quantity = quantity - :qty
                    WHERE id = :id
                    "
                );

                /**
                 * Movement log
                 */
                $this->createMovement([
                    'product_id' => $productId,
                    'batch_id' => $batch['id'],
                    'movement_type' => 'sale',
                    'quantity' => $deduct,
                    'notes' => 'FEFO deduction'
                ]);

                $remaining -= $deduct;
            }

            if ($remaining > 0) {
                throw new Exception('Insufficient stock');
            }

            $this->db->commit();

            return true;

        } catch (Exception $e) {

            $this->db->rollBack();

            return false;
        }
    }
  public function markExpired(
    int $batchId,
    int $qty,
    string $reason = 'Expired stock'
): bool {

    try {

        $this->db->beginTransaction();

        $statement = $this->db->prepare(
            "
            SELECT *
            FROM inventory_batches
            WHERE id = :id
            "
        );

        $statement->execute([
            'id' => $batchId
        ]);

        $batch = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$batch) {
            throw new Exception();
        }

        if ($batch['quantity'] < $qty) {
            throw new Exception();
        }

        $update = $this->db->prepare(
            "
            UPDATE inventory_batches
            SET quantity = quantity - :qty
            WHERE id = :id
            "
        );

        $update->execute([
            'qty' => $qty,
            'id' => $batchId
        ]);

        $this->createMovement([
            'product_id' => $batch['product_id'],
            'batch_id' => $batchId,
            'movement_type' => 'expired',
            'quantity' => $qty,
            'notes' => $reason
        ]);

        $this->db->commit();

        return true;

    } catch (Exception $e) {

        $this->db->rollBack();

        return false;
    }
}

public function markDamaged(
    int $batchId,
    int $qty,
    string $reason = 'Damaged stock'
): bool {

    try {

        $this->db->beginTransaction();

        $statement = $this->db->prepare(
            "
            SELECT *
            FROM inventory_batches
            WHERE id = :id
            "
        );

        $statement->execute([
            'id' => $batchId
        ]);

        $batch = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$batch) {
            throw new Exception();
        }

        if ($batch['quantity'] < $qty) {
            throw new Exception();
        }

        $update = $this->db->prepare(
            "
            UPDATE inventory_batches
            SET quantity = quantity - :qty
            WHERE id = :id
            "
        );

        $update->execute([
            'qty' => $qty,
            'id' => $batchId
        ]);

        $this->createMovement([
            'product_id' => $batch['product_id'],
            'batch_id' => $batchId,
            'movement_type' => 'damaged',
            'quantity' => $qty,
            'notes' => $reason
        ]);

        $this->db->commit();

        return true;

    } catch (Exception $e) {

        $this->db->rollBack();

        return false;
    }
}

}