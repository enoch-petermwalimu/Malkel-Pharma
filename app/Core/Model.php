<?php

namespace App\Core;

use PDO;

/**
 * Base model
 */
abstract class Model
{
    protected PDO $db;

    protected string $table = '';

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Get all rows
     */
    public function all(): array
    {
        $statement = $this->db->query(
            "SELECT * FROM {$this->table}"
        );

        return $statement->fetchAll();
    }

    /**
     * Find by id
     */
    public function find(int $id): array|false
    {


    echo "<pre>";

        $statement = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1"
        );

        $statement->execute([
            'id' => $id
        ]);

        return $statement->fetch();
    }

    /**
     * Create row
     */
    public function create(array $data): bool
    {
        $columns = array_keys($data);

        $placeholders = array_map(
            fn($column) => ':' . $column,
            $columns
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $statement = $this->db->prepare($sql);

        return $statement->execute($data);
    }

    /**
     * Update row
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];

        foreach ($data as $key => $value) {
            $fields[] = "{$key} = :{$key}";
        }

        $data['id'] = $id;

        $sql = sprintf(
            "UPDATE %s SET %s WHERE id = :id",
            $this->table,
            implode(', ', $fields)
        );

        $statement = $this->db->prepare($sql);

        return $statement->execute($data);
    }

    /**
     * Delete row
     */
    public function delete(int $id): bool
    {
        $statement = $this->db->prepare(
            "DELETE FROM {$this->table} WHERE id = :id"
        );

        return $statement->execute([
            'id' => $id
        ]);
    }

    /**
     * Get last inserted ID
     */
    public function lastInsertId(): string|false
    {
        return $this->db->lastInsertId();
    }
}
