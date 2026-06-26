<?php

namespace App\Modules\Auth\Repositories;

use App\Repositories\BaseRepository;
use PDO;

/**
 * ----------------------------------------------------------------
 * User Repository
 * ----------------------------------------------------------------
 * Gestion accès DB users.
 * ----------------------------------------------------------------
 */

class UserRepository extends BaseRepository
{
    /**
     * Table SQL
     */
    protected string $table = 'users';

    /**
     * Recherche utilisateur par email
     */
    public function findByEmail(string $email): array|false
    {
        $statement = $this->db->prepare(
            "SELECT * FROM {$this->table}
             WHERE email = :email
             LIMIT 1"
        );

        $statement->execute([
            'email' => $email
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}