<?php

namespace App\Modules\Returns\Services;

use App\Core\Database;
use App\Modules\Returns\Models\ReturnModel;
use App\Modules\Returns\Models\ReturnItem;
use App\Modules\Returns\Repositories\ReturnRepository;
use App\Modules\Inventory\Services\InventoryService;
use PDO;
use Exception;

/**
 * ============================================================
 * Return service
 * ============================================================
 */
class ReturnService
{
    protected ReturnModel $returnModel;
    protected ReturnItem $itemModel;
    protected ReturnRepository $repository;
    protected InventoryService $inventory;
    protected PDO $db;

    public function __construct()
    {
        $this->returnModel = new ReturnModel();
        $this->itemModel = new ReturnItem();
        $this->repository = new ReturnRepository();
        $this->inventory = new InventoryService();
        $this->db = Database::connect();
    }

    /**
     * Create a return
     */
    public function create(array $data): array|false
    {
        try {
            $this->db->beginTransaction();

            $returnNumber = $this->repository->generateReturnNumber();

            $totalRefund = 0;
            foreach ($data['items'] as $item) {
                $totalRefund += $item['quantity'] * $item['unit_price'];
            }

            $created = $this->repository->createReturn([
                'return_number' => $returnNumber,
                'sale_id' => $data['sale_id'] ?? null,
                'customer_id' => $data['customer_id'] ?? null,
                'user_id' => $_SESSION['user']['id'] ?? null,
                'reason' => $data['reason'] ?? null,
                'total_refund' => $totalRefund,
                'status' => 'completed'
            ]);

            if (!$created) {
                throw new Exception('Failed to create return');
            }

            $returnId = (int) $this->db->lastInsertId();

            foreach ($data['items'] as $item) {
                $this->repository->createItem([
                    'return_id' => $returnId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_refund' => $item['quantity'] * $item['unit_price'],
                    'reason' => $item['reason'] ?? null
                ]);

                // Restore inventory
                $this->inventory->receiveStock([
                    'product_id' => $item['product_id'],
                    'batch_number' => 'RET-' . $returnNumber,
                    'expiry_date' => date('Y-m-d', strtotime('+5 years')),
                    'quantity' => $item['quantity'],
                    'supplier' => null,
                    'purchase_price' => 0,
                    'selling_price' => $item['unit_price'],
                    'minimum_stock_level' => 0
                ]);
            }

            $this->db->commit();

            return [
                'return_id' => $returnId,
                'return_number' => $returnNumber
            ];

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * All returns
     */
    public function all(): array
    {
        return $this->repository->allReturns();
    }

    /**
     * Find return
     */
    public function find(int $id): array|false
    {
        return $this->repository->findReturn($id);
    }

    /**
     * Get return items
     */
    public function items(int $returnId): array
    {
        return $this->repository->getItems($returnId);
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

    // Reuse the create method for the return record
    $result = $this->create([
        'sale_id' => $data['sale_id'],
        'customer_id' => $data['customer_id'],
        'reason' => $data['reason'],
        'items' => []
    ]);

    if (!$result) {
        return false;
    }

    $returnId = $result['return_id'];

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
