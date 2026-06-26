<?php

namespace App\Modules\Customers\Repositories;

use App\Repositories\BaseRepository;
use PDO;

/**
 * -------------------------------------------------------------
 * Customer Repository
 * -------------------------------------------------------------
 */
class CustomerRepository extends BaseRepository
{
    protected string $table = 'customers';

    /**
     * Search customers
     */
    public function search(string $query): array
    {
        $statement = $this->db->prepare(
            "SELECT *
             FROM customers
             WHERE
                full_name LIKE :query
                OR phone LIKE :query
             LIMIT 20"
        );

        $statement->execute([
            'query' => '%' . $query . '%'
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}