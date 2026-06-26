<?php

namespace App\Modules\Returns\Services;

use App\Modules\Returns\Models\ReturnModel;
use App\Modules\Returns\Models\ReturnItem;
use App\Modules\Inventory\Services\InventoryService;

/**
 * ============================================================
 * Return service
 * ============================================================
 */
class ReturnService
{
    protected ReturnModel $returnModel;
    protected ReturnItem $itemModel;
    protected InventoryService $inventory;

    public function __construct()
    {
        $this->returnModel = new ReturnModel();
        $this->itemModel = new ReturnItem();
        $this->inventory = new InventoryService();
    }

    /**
     * Customer return
     */
    public function customerReturn(array $data): bool
{
    $saleRepo =
        new \App\Modules\Sales\Repositories\SaleRepository();

    $soldItems =
        $saleRepo->saleItems(
            (int) $data['sale_id']
        );

    $soldMap = [];

    foreach ($soldItems as $sold) {
        $soldMap[$sold['product_id']] = $sold;
    }

    $this->returnModel->create([
        'return_type' => 'customer_return',
        'reference_type' => 'sale',
        'reference_id' => $data['sale_id'],
        'customer_id' => $data['customer_id'],
        'total_amount' => $data['total_amount'],
        'refund_type' => $data['refund_type'],
        'reason' => $data['reason']
    ]);

    $returnId =
        (int) $this->returnModel->lastInsertId();

    foreach ($data['items'] as $item) {

        if (!isset($soldMap[$item['product_id']])) {
            return false;
        }

        $sold =
            $soldMap[$item['product_id']];

        /**
         * Prevent over-return
         */
        if (
            (int) $item['quantity']
            > (int) $sold['quantity']
        ) {
            return false;
        }

        $safeRestock =
            $item['restock'] ?? false;

        /**
         * Pharma restrictions - check product properties
         * These columns may not exist in the products table,
         * so we default to allowing restock if the property is missing
         */
        $productStmt = $this->db->prepare(
            "SELECT is_temperature_sensitive, requires_prescription 
             FROM products WHERE id = ? LIMIT 1"
        );
        $productStmt->execute([$item['product_id']]);
        $product = $productStmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $isTemperatureSensitive = (bool) ($product['is_temperature_sensitive'] ?? false);
            $isPrescriptionOnly = (bool) ($product['requires_prescription'] ?? false);
        } else {
            $isTemperatureSensitive = false;
            $isPrescriptionOnly = false;
        }

        if ($isTemperatureSensitive || $isPrescriptionOnly) {
            $safeRestock = false;
        }

        $this->itemModel->create([
            'return_id' => $returnId,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'unit_price' => $item['unit_price'],
            'restocked' =>
                $safeRestock ? 1 : 0
        ]);

        /**
         * Controlled restock
         */
        if ($safeRestock) {

            $this->inventory->receiveStock([
                'product_id' =>
                    $item['product_id'],

                'batch_number' =>
                    'RETURN-' . time(),

                'expiry_date' =>
                    date('Y-m-d', strtotime('+90 days')),

                'quantity' =>
                    $item['quantity'],

                'purchase_price' =>
                    $item['unit_price'],

                'selling_price' =>
                    $item['unit_price']
            ]);
        }
    }

    return true;
}

    /**
     * Supplier return
     */
    public function supplierReturn(array $data): bool
    {
        $this->returnModel->create([
            'return_type' => 'supplier_return',
            'reference_type' => 'purchase',
            'reference_id' => $data['purchase_id'],
            'supplier_id' => $data['supplier_id'],
            'reason' => $data['reason']
        ]);

        $returnId =
            (int) $this->returnModel->lastInsertId();

        foreach ($data['items'] as $item) {

            $this->itemModel->create([
                'return_id' => $returnId,
                'product_id' => $item['product_id'],
                'batch_id' => $item['batch_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'restocked' => 0
            ]);

            /**
             * Deduct stock
             */
            $this->inventory->markDamaged(
                (int) $item['batch_id'],
                (int) $item['quantity'],
                'Supplier return'
            );
        }

        return true;
    }
} 
