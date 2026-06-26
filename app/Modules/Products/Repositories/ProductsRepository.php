<?php

namespace App\Modules\Products\Repositories;

use App\Repositories\BaseRepository;
use PDO;

/**
 * -------------------------------------------------------------
 * Product Repository
 * -------------------------------------------------------------
 */
class ProductRepository extends BaseRepository
{
    protected string $table = 'products';

    /**
     * Search text
     */
    public function search(string $query): array
    {
        $statement = $this->db->prepare(
            "SELECT *
             FROM products
             WHERE
                name LIKE :query
                OR sku LIKE :query
                OR barcode LIKE :query
             LIMIT 20"
        );

        $statement->execute([
            'query' => '%' . $query . '%'
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Exact barcode
     */
    public function findByBarcode(
        string $barcode
    ): array|false {

        $statement = $this->db->prepare(
            "SELECT *
             FROM products
             WHERE barcode = :barcode
             LIMIT 1"
        );

        $statement->execute([
            'barcode' => $barcode
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}