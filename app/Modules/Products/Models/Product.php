<?php

namespace App\Modules\Products\Models;

use App\Core\Model;
use PDO;

/**
 * Product model
 */
class Product extends Model
{
    protected string $table = 'products';

    public function search(string $query): array
    {
        $statement = $this->db->prepare("
            SELECT *
            FROM products
            WHERE name LIKE :query
               OR barcode LIKE :query
               OR sku LIKE :query
        ");

        $statement->execute([
            'query' => "%{$query}%"
        ]);

        return $statement->fetchAll();
    }

    public function findByBarcode(string $barcode): ?array
    {
        $statement = $this->db->prepare("
            SELECT *
            FROM products
            WHERE barcode = :barcode
            LIMIT 1
        ");

        $statement->execute([
            'barcode' => $barcode
        ]);

        $result = $statement->fetch();

        return $result ?: null;
    }

    public function allWithStock(): array
    {
        $statement = $this->db->query("
            SELECT
                p.*,

                COALESCE(
                    SUM(b.quantity),
                    0
                ) AS current_stock

            FROM products p

            LEFT JOIN inventory_batches b
                ON b.product_id = p.id

            GROUP BY p.id

            ORDER BY p.name ASC
        ");

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}