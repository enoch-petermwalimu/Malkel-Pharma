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
}