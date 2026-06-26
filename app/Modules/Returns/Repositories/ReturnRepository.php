<?php

namespace App\Modules\Returns\Repositories;

use App\Repositories\BaseRepository;
use PDO;

/**
 * Return Repository
 */
class ReturnRepository extends BaseRepository
{
    protected string $table = 'returns';

    /**
     * Generate return number
     */
    public function generateReturnNumber(): string
    {
        return 'RET-'
            . date('Ymd')
            . '-'
            . rand(1000, 9999);
    }

    /**
     * Create return record
     */
    public function createReturn(array $data): bool
    {
        $statement = $this->db->prepare("
            INSERT INTO returns (
                return_number,
                sale_id,
                customer_id,
                user_id,
                reason,
                total_refund,
                status
            ) VALUES (
                :return_number,
                :sale_id,
                :customer_id,
                :user_id,
                :reason,
                :total_refund,
                :status
            )
        ");

        return $statement->execute($data);
    }

    /**
     * Create return item
     */
    public function createItem(array $data): bool
    {
        $statement = $this->db->prepare("
            INSERT INTO return_items (
                return_id,
                product_id,
                quantity,
                unit_price,
                total_refund,
                reason
            ) VALUES (
                :return_id,
                :product_id,
                :quantity,
                :unit_price,
                :total_refund,
                :reason
            )
        ");

        return $statement->execute($data);
    }

    /**
     * All returns
     */
    public function allReturns(): array
    {
        $statement = $this->db->query("
            SELECT
                r.*,
                s.invoice_number,
                c.full_name AS customer_name
            FROM returns r
            LEFT JOIN sales s ON s.id = r.sale_id
            LEFT JOIN customers c ON c.id = r.customer_id
            ORDER BY r.id DESC
        ");

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find return by id
     */
    public function findReturn(int $id): array|false
    {
        $statement = $this->db->prepare("
            SELECT
                r.*,
                s.invoice_number,
                c.full_name AS customer_name,
                c.phone AS customer_phone
            FROM returns r
            LEFT JOIN sales s ON s.id = r.sale_id
            LEFT JOIN customers c ON c.id = r.customer_id
            WHERE r.id = :id
            LIMIT 1
        ");

        $statement->execute(['id' => $id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get return items
     */
    public function getItems(int $returnId): array
    {
        $statement = $this->db->prepare("
            SELECT
                ri.*,
                p.name AS product_name
            FROM return_items ri
            JOIN products p ON p.id = ri.product_id
            WHERE ri.return_id = :return_id
        ");

        $statement->execute(['return_id' => $returnId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
