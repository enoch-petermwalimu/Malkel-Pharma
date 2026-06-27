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
        return 'INV-'
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
            p.name as product_name,
            p.allow_customer_restock,
            p.is_temperature_sensitive,
            p.is_prescription_only
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

                LEFT JOIN sale_payments sp
                    ON sp.sale_id = s.id

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

    public function latestSales(): array
    {
        $statement = $this->db->query(
            "
            SELECT
                s.*,
                c.full_name customer_name
            FROM sales s
            LEFT JOIN customers c
                ON c.id = s.customer_id
            ORDER BY s.created_at DESC
            LIMIT 100
            "
        );

        return $statement->fetchAll(PDO::FETCH_ASSOC);
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
}