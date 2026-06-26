<?php

namespace App\Modules\Inventory\Repositories;

use App\Repositories\BaseRepository;
use PDO;

/**
 * Inventory repository
 */
class InventoryRepository extends BaseRepository
{
    protected string $table = 'inventory_batches';

    /**
     * All stock batches
     */
    public function allBatches(): array
    {
        $statement = $this->db->query(
            "
            SELECT
                b.*,
                p.name as product_name
            FROM inventory_batches b
            JOIN products p
                ON p.id = b.product_id
            ORDER BY b.expiry_date ASC
            "
        );

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function expiringSoon(): array
    {
        $statement = $this->db->query(
            "
            SELECT *
            FROM inventory_batches
            WHERE expiry_date <= DATE_ADD(NOW(), INTERVAL 30 DAY)
            "
        );

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lowStock(): array
    {
        $statement = $this->db->query(
            "
            SELECT
                p.name,
                SUM(b.quantity) as total_stock,
                COALESCE(p.minimum_stock_level, p.minimum_stock, 0) as minimum_stock
            FROM inventory_batches b
            JOIN products p
                ON p.id = b.product_id
            GROUP BY p.id
            HAVING total_stock <= minimum_stock
            "
        );

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create a batch record
     */
    public function create(array $data): bool
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ':' . $col, $columns);

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $statement = $this->db->prepare($sql);
        return $statement->execute($data);
    }
}
