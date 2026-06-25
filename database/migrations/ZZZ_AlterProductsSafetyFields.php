<?php

use App\Core\Migration;

class AlterProductsSafetyFields extends Migration
{
    public function up(): void
    {
        $columns = [];

        $result = $this->db->query("
            SHOW COLUMNS FROM products
        ");

        foreach ($result->fetchAll() as $column) {
            $columns[] = $column['Field'];
        }

        if (!in_array('is_temperature_sensitive', $columns)) {
            $this->db->exec("
                ALTER TABLE products
                ADD COLUMN is_temperature_sensitive TINYINT(1) DEFAULT 0
            ");
        }

        if (!in_array('storage_temperature', $columns)) {
            $this->db->exec("
                ALTER TABLE products
                ADD COLUMN storage_temperature VARCHAR(100) NULL
            ");
        }

        if (!in_array('is_controlled_substance', $columns)) {
            $this->db->exec("
                ALTER TABLE products
                ADD COLUMN is_controlled_substance TINYINT(1) DEFAULT 0
            ");
        }

        if (!in_array('minimum_stock_level', $columns)) {
            $this->db->exec("
                ALTER TABLE products
                ADD COLUMN minimum_stock_level INT DEFAULT 0
            ");
        }
    }

    public function down(): void
    {
    }
}