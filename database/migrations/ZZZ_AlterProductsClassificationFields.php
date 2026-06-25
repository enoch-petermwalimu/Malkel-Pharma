<?php

use App\Core\Migration;

class AlterProductsClassificationFields extends Migration
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

        if (!in_array('category_id', $columns)) {
            $this->db->exec("
                ALTER TABLE products
                ADD COLUMN category_id INT NULL
            ");
        }

        if (!in_array('dosage_form_id', $columns)) {
            $this->db->exec("
                ALTER TABLE products
                ADD COLUMN dosage_form_id INT NULL
            ");
        }

        if (!in_array('packaging_unit_id', $columns)) {
            $this->db->exec("
                ALTER TABLE products
                ADD COLUMN packaging_unit_id INT NULL
            ");
        }

        if (!in_array('strength', $columns)) {
            $this->db->exec("
                ALTER TABLE products
                ADD COLUMN strength VARCHAR(100) NULL
            ");
        }

        if (!in_array('purchase_price', $columns)) {
            $this->db->exec("
                ALTER TABLE products
                ADD COLUMN purchase_price DECIMAL(10,2) DEFAULT 0
            ");
        }

        if (!in_array('prescription_required', $columns)) {
            $this->db->exec("
                ALTER TABLE products
                ADD COLUMN prescription_required TINYINT(1) DEFAULT 0
            ");
        }
    }

    public function down(): void
    {
    }
}