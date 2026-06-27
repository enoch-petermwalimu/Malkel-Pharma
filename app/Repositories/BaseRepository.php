<?php

namespace App\Repositories;

use PDO;
use App\Core\Database;

abstract class BaseRepository
{
    protected PDO $db;

    protected string $table;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all(): array
    {
        $statement = $this->db->query(
            "SELECT * FROM {$this->table}"
        );

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): array|false
    {
        $statement = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id = :id"
        );

        $statement->execute([
            'id' => $id
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    public function lastInsertId(): string|false
    {
        return $this->db->lastInsertId();
    }

}