<?php

namespace App\Modules\Suppliers\Repositories;

use App\Repositories\BaseRepository;
use PDO;

/**
 * Supplier Repository
 */
class SupplierRepository extends BaseRepository
{
    protected string $table = 'suppliers';

    /**
     * Search suppliers
     */
    public function search(string $query): array
    {
        $statement = $this->db->prepare(
            "SELECT *
             FROM suppliers
             WHERE
                company_name LIKE :query
                OR contact_name LIKE :query
                OR phone LIKE :query
             LIMIT 20"
        );

        $statement->execute([
            'query' => '%' . $query . '%'
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Update supplier
     */
    public function update(
        int $id,
        array $data
    ): bool {

        $statement =
            $this->db->prepare(
                "
                UPDATE suppliers
                SET
                    company_name = :company_name,
                    contact_name = :contact_name,
                    phone = :phone,
                    email = :email,
                    address = :address,
                    notes = :notes
                WHERE id = :id
                "
            );

        return $statement->execute([

            'company_name' =>
                $data['company_name'],

            'contact_name' =>
                $data['contact_name'],

            'phone' =>
                $data['phone'],

            'email' =>
                $data['email'],

            'address' =>
                $data['address'],

            'notes' =>
                $data['notes'],

            'id' =>
                $id
        ]);
    }

    /**
     * Disable supplier (set status = 0)
     */
    public function disable(int $id): bool
    {
        $statement = $this->db->prepare(
            "
            UPDATE suppliers
            SET status = 0
            WHERE id = :id
            "
        );

        return $statement->execute([
            'id' => $id
        ]);
    }

    /**
     * Find supplier by ID
     */
    public function find(int $id): ?array
    {
        $statement = $this->db->prepare(
            "
            SELECT *
            FROM suppliers
            WHERE id = :id
            LIMIT 1
            "
        );

        $statement->execute([
            'id' => $id
        ]);

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    /**
     * Purchase history for a supplier
     */
    public function purchaseHistory(int $supplierId): array
    {
        $statement = $this->db->prepare(
            "
            SELECT
                p.*,
                s.company_name
            FROM purchases p
            LEFT JOIN suppliers s
                ON s.id = p.supplier_id
            WHERE p.supplier_id = :supplier_id
            ORDER BY p.id DESC
            "
        );

        $statement->execute([
            'supplier_id' => $supplierId
        ]);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
