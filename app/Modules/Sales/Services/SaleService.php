<?php

namespace App\Modules\Sales\Services;

use App\Core\Database;
use PDO;

use App\Modules\Sales\Models\Sale;
use App\Modules\Sales\Models\SaleItem;
use App\Modules\Sales\Models\SalePayment;

use App\Modules\Sales\Repositories\SaleRepository;

use App\Modules\Inventory\Services\InventoryService;

/**
 * -------------------------------------------------------------
 * Sale Service
 * -------------------------------------------------------------
 * Checkout réel POS
 * -------------------------------------------------------------
 */
class SaleService
{
    protected PDO $db;

    protected Sale $saleModel;
    protected SaleItem $itemModel;
    protected SalePayment $paymentModel;
    protected SaleRepository $repository;
    protected InventoryService $inventory;

    public function __construct()
    {
        $this->db = Database::connect();

        $this->saleModel = new Sale();
        $this->itemModel = new SaleItem();
        $this->paymentModel = new SalePayment();
        $this->repository = new SaleRepository();
        $this->inventory = new InventoryService();
    }

    /**
     * Checkout complet
     */
    public function createSale(array $data): array|false
    {
        try {
            $this->db->beginTransaction();

            /**
             * Invoice
             */
            $invoiceNumber = $this->repository->generateInvoiceNumber();

            /**
             * Calculate totals
             */
            if (!isset($data['items']) || !is_array($data['items']) || empty($data['items'])) {
                throw new \Exception('No items in sale');
            }

            $subtotal = 0;
            foreach ($data['items'] as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $discount = (float) ($data['discount'] ?? 0);
            $tax = 0;
            $total = $subtotal - $discount + $tax;

            /**
             * Customer auto creation
             */
            $customerId = null;
            $customerName = trim($data['customer_name'] ?? '');
            $customerPhone = trim($data['customer_phone'] ?? '');

            if ($customerName !== '') {
                $stmt = $this->db->prepare(
                    "SELECT id FROM customers WHERE phone = ? LIMIT 1"
                );
                $stmt->execute([$customerPhone]);
                $customer = $stmt->fetch();

                if ($customer) {
                    $customerId = (int) $customer['id'];
                } else {
                    $insert = $this->db->prepare(
                        "INSERT INTO customers (full_name, phone) VALUES (?, ?)"
                    );
                    $insert->execute([$customerName, $customerPhone]);
                    $customerId = (int) $this->db->lastInsertId();
                }
            }

            /**
             * Main sale
             */
            $created = $this->saleModel->create([
                'invoice_number' => $invoiceNumber,
                'customer_id' => $customerId,
                'user_id' => $_SESSION['user']['id'] ?? null,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'payment_status' => 'paid',
                'sale_status' => 'completed',
                'currency_mode' => $data['currency_mode'] ?? 'USD',
                'exchange_rate' => $data['exchange_rate'] ?? 2850,
                'amount_received_usd' => $data['amount_received_usd'] ?? 0,
                'amount_received_cdf' => $data['amount_received_cdf'] ?? 0,
                'change_usd' => $data['change_usd'] ?? 0,
                'change_cdf' => $data['change_cdf'] ?? 0,
            ]);

            if (!$created) {
                throw new \Exception('Failed to create sale record');
            }

            $saleId = (int) $this->db->lastInsertId();

            /**
             * Items
             */
            foreach ($data['items'] as $item) {
                $productStmt = $this->db->prepare(
                    "SELECT name FROM products WHERE id = ? LIMIT 1"
                );
                $productStmt->execute([$item['product_id']]);
                $product = $productStmt->fetch();

                if (!$product) {
                    throw new \Exception('Product not found: ' . $item['product_id']);
                }

                $this->itemModel->create([
                    'sale_id' => $saleId,
                    'product_id' => $item['product_id'],
                    'batch_id' => null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price']
                ]);

                /**
                 * Stock deduction
                 */
                $deducted = $this->inventory->deductStock(
                    (int) $item['product_id'],
                    (int) $item['quantity']
                );

                if (!$deducted) {
                    throw new \Exception('Insufficient stock for product: ' . $product['name']);
                }
            }

            /**
             * Payment
             */
            $this->paymentModel->create([
                'sale_id' => $saleId,
                'payment_method' => $data['payment_method'] ?? 'cash',
                'amount' => $total,
                'payment_status' => 'paid',
            ]);

            $this->db->commit();

            return [
                'sale_id' => $saleId,
                'invoice_number' => $invoiceNumber
            ];

        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
