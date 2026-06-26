<?php

namespace App\Modules\Sales\Repositories;

use App\Repositories\BaseRepository;
use PDO;

/**
 * -------------------------------------------------------------
 * Sale Repository
 * -------------------------------------------------------------
 * Analytics ventes
 * -------------------------------------------------------------
 */
class SaleRepository extends BaseRepository
{
    protected string $table = 'sales';

    /**
     * Invoice generator
     */
    public function generateInvoiceNumber(): string
    {
        $settingsService = new \App\Modules\Settings\Services\SettingsService();
        $prefix = $settingsService->invoicePrefix();

        return $prefix
            . date('Ymd')
            . '-'
            . rand(1000, 9999);
    }

    /**
     * Today's sales
     */
    public function todaySales(): array
    {
        $statement = $this->db->query(
            "SELECT *
             FROM sales
             WHERE DATE(created_at)=CURDATE()"
        );

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Revenue total
     */
    public function totalRevenue(): float
    {
        $statement = $this->db->query(
            "SELECT SUM(total) as revenue
             FROM sales"
        );

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return (float) ($result['revenue'] ?? 0);
    }

    /**
     * Sales count
     */
    public function totalSalesCount(): int
    {
        $statement = $this->db->query(
            "SELECT COUNT(*) as count
             FROM sales"
        );

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return (int) $result['count'];
    }

    /**
     * Today's revenue
     */
    public function todayRevenue(): float
    {
        $statement = $this->db->query(
            "SELECT SUM(total) as revenue
             FROM sales
             WHERE DATE(created_at)=CURDATE()"
        );

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return (float) ($result['revenue'] ?? 0);
    }

    /**
     * Top selling products
     */
    public function topProducts(): array
    {
        $statement = $this->db->query(
            "
            SELECT
                p.name,
                SUM(si.quantity) as sold_qty
            FROM sale_items si
            JOIN products p
                ON p.id = si.product_id
            GROUP BY si.product_id
            ORDER BY sold_qty DESC
            LIMIT 10
            "
        );

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
 * Find invoice
 */
public function findByInvoice(
    string $invoice
): array|false {

    $statement = $this->db->prepare(
        "
        SELECT *
        FROM sales
        WHERE invoice_number = :invoice
        LIMIT 1
        "
    );

    $statement->execute([
        'invoice' => $invoice
    ]);

    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Sale items
 */
public function saleItems(
    int $saleId
): array {

    $statement = $this->db->prepare(
        "
        SELECT
            si.*,
            p.name as product_name
        FROM sale_items si
        JOIN products p
            ON p.id = si.product_id
        WHERE si.sale_id = :sale_id
        "
    );

    $statement->execute([
        'sale_id' => $saleId
    ]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

 public function find(
        int $saleId
    ): array|false {

        $statement =
            $this->db->prepare(
                "
                SELECT

                    s.*,

                    c.full_name
                        AS customer_name,

                    c.phone
                        AS customer_phone,

                    u.full_name
                        AS cashier_name,

                    sp.payment_method,

                    sp.amount
                        AS paid_amount

                FROM sales s

                LEFT JOIN customers c
                    ON c.id = s.customer_id

                LEFT JOIN users u
                    ON u.id = s.user_id

                LEFT JOIN (
                    SELECT sale_id, payment_method, amount
                    FROM sale_payments
                    GROUP BY sale_id
                ) sp ON sp.sale_id = s.id

                WHERE s.id = :id

                LIMIT 1
                "
            );

        $statement->execute([
            'id' => $saleId
        ]);

        return $statement->fetch(
            PDO::FETCH_ASSOC
        );
    }


public function saleDetails(
    int $saleId
): array {

    $statement = $this->db->prepare(
        "
        SELECT
            si.*,
            p.name
        FROM sale_items si
        JOIN products p
            ON p.id = si.product_id
        WHERE si.sale_id = :sale_id
        "
    );

    $statement->execute([
        'sale_id' => $saleId
    ]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


    public function revenueLast3Days(): float
    {
        $statement = $this->db->query(
            "
            SELECT SUM(total) revenue
            FROM sales
            WHERE created_at >= DATE_SUB(
                NOW(),
                INTERVAL 3 DAY
            )
            "
        );

        $result =
            $statement->fetch(PDO::FETCH_ASSOC);

        return (float)
            ($result['revenue'] ?? 0);
    }


    public function revenueLast7Days(): float
    {
        $statement = $this->db->query(
            "
            SELECT SUM(total) revenue
            FROM sales
            WHERE created_at >= DATE_SUB(
                NOW(),
                INTERVAL 7 DAY
            )
            "
        );

        $result =
            $statement->fetch(PDO::FETCH_ASSOC);

        return (float)
            ($result['revenue'] ?? 0);
    }

    public function revenueBetween(
        string $start,
        string $end
    ): float {

        $statement =
            $this->db->prepare(
                "
                SELECT SUM(total) revenue
                FROM sales
                WHERE DATE(created_at)
                BETWEEN :start
                AND :end
                "
            );

        $statement->execute([
            'start' => $start,
            'end' => $end
        ]);

        $result =
            $statement->fetch(PDO::FETCH_ASSOC);

        return (float)
            ($result['revenue'] ?? 0);
    }


public function revenueDays(int $days): float
{
    $statement = $this->db->prepare(
        "
        SELECT SUM(total) revenue
        FROM sales
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)
        "
    );

    $statement->bindValue(':days', $days, PDO::PARAM_INT);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return (float)($result['revenue'] ?? 0);
}

    public function latestSales(int $limit = 100): array
    {
        $statement = $this->db->prepare(
            "
            SELECT
                s.*,
                c.full_name customer_name
            FROM sales s
            LEFT JOIN customers c
                ON c.id = s.customer_id
            ORDER BY s.created_at DESC
            LIMIT :limit
            "
        );

        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create sale record
     */
    public function create(array $data): bool
    {
        $statement = $this->db->prepare("
            INSERT INTO sales (
                invoice_number,
                customer_id,
                user_id,
                subtotal,
                discount,
                vat,
                total,
                payment_method,
                amount_received,
                status
            ) VALUES (
                :invoice_number,
                :customer_id,
                :user_id,
                :subtotal,
                :discount,
                :vat,
                :total,
                :payment_method,
                :amount_received,
                :status
            )
        ");

        return $statement->execute([
            'invoice_number' => $data['invoice_number'],
            'customer_id' => $data['customer_id'],
            'user_id' => $data['user_id'],
            'subtotal' => $data['subtotal'],
            'discount' => $data['discount'],
            'vat' => $data['vat'],
            'total' => $data['total'],
            'payment_method' => $data['payment_method'],
            'amount_received' => $data['amount_received'],
            'status' => $data['status']
        ]);
    }

    /**
     * Create sale item
     */
    public function createItem(array $data): bool
    {
        $statement = $this->db->prepare("
            INSERT INTO sale_items (
                sale_id,
                product_id,
                quantity,
                unit_price,
                total_price
            ) VALUES (
                :sale_id,
                :product_id,
                :quantity,
                :unit_price,
                :total_price
            )
        ");

        return $statement->execute([
            'sale_id' => $data['sale_id'],
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'unit_price' => $data['unit_price'],
            'total_price' => $data['total_price']
        ]);
    }

    /**
     * Create payment record
     */
    public function createPayment(array $data): bool
    {
        $statement = $this->db->prepare("
            INSERT INTO sale_payments (
                sale_id,
                payment_method,
                amount
            ) VALUES (
                :sale_id,
                :payment_method,
                :amount
            )
        ");

        return $statement->execute([
            'sale_id' => $data['sale_id'],
            'payment_method' => $data['payment_method'],
            'amount' => $data['amount']
        ]);
    }

    public function history(): array
    {
        $statement = $this->db->query(
            "
            SELECT
                s.*,
                c.full_name AS customer_name
            FROM sales s
            LEFT JOIN customers c
                ON c.id = s.customer_id
            ORDER BY s.created_at DESC
            "
        );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Get daily sales for the last 7 days
     */
    public function dailySalesLast7Days(): array
    {
        $statement = $this->db->query(
            "
            SELECT
                DATE(created_at) as date,
                SUM(total) as revenue,
                COUNT(*) as count
            FROM sales
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            GROUP BY DATE(created_at)
            ORDER BY DATE(created_at) ASC
            "
        );

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
