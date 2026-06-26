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
            SELECT p.*,
                   COALESCE(SUM(b.quantity), 0) AS current_stock
            FROM products p
            LEFT JOIN inventory_batches b ON b.product_id = p.id
            WHERE p.name LIKE :query
               OR p.barcode LIKE :query
               OR p.sku LIKE :query
               OR p.active_ingredient LIKE :query
               OR p.manufacturer LIKE :query
               OR p.category LIKE :query
            GROUP BY p.id
            ORDER BY p.name ASC
            LIMIT 50
        ");

        $statement->execute([
            'query' => "%{$query}%"
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByBarcode(string $barcode): ?array
    {
        $statement = $this->db->prepare("
            SELECT p.*,
                   COALESCE(SUM(b.quantity), 0) AS current_stock
            FROM products p
            LEFT JOIN inventory_batches b ON b.product_id = p.id
            WHERE p.barcode = :barcode
            GROUP BY p.id
            LIMIT 1
        ");

        $statement->execute([
            'barcode' => $barcode
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

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

    public function find(int $id): array|false
    {
        $statement = $this->db->prepare("
            SELECT p.*,
                   COALESCE(SUM(b.quantity), 0) AS current_stock
            FROM products p
            LEFT JOIN inventory_batches b ON b.product_id = p.id
            WHERE p.id = :id
            GROUP BY p.id
            LIMIT 1
        ");

        $statement->execute(['id' => $id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
