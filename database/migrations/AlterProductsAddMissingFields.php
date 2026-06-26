<?php

use App\Core\Migration;

class AlterProductsAddMissingFields extends Migration
{
    public function up(): void
    {
        $columns = [];
        $result = $this->db->query("SHOW COLUMNS FROM products");
        foreach ($result->fetchAll() as $column) {
            $columns[] = $column['Field'];
        }

        $additions = [];

        if (!in_array('dosage_form_id', $columns)) {
            $additions[] = "ADD COLUMN dosage_form_id INT NULL AFTER category";
        }
        if (!in_array('packaging_unit_id', $columns)) {
            $additions[] = "ADD COLUMN packaging_unit_id INT NULL AFTER dosage_form_id";
        }
        if (!in_array('strength', $columns)) {
            $additions[] = "ADD COLUMN strength VARCHAR(100) NULL AFTER packaging_unit_id";
        }
        if (!in_array('purchase_price', $columns)) {
            $additions[] = "ADD COLUMN purchase_price DECIMAL(10,2) DEFAULT 0 AFTER selling_price";
        }
        if (!in_array('therapeutic_class', $columns)) {
            $additions[] = "ADD COLUMN therapeutic_class VARCHAR(255) NULL AFTER purchase_price";
        }
        if (!in_array('active_ingredient', $columns)) {
            $additions[] = "ADD COLUMN active_ingredient VARCHAR(255) NULL AFTER therapeutic_class";
        }
        if (!in_array('manufacturer', $columns)) {
            $additions[] = "ADD COLUMN manufacturer VARCHAR(255) NULL AFTER active_ingredient";
        }
        if (!in_array('is_temperature_sensitive', $columns)) {
            $additions[] = "ADD COLUMN is_temperature_sensitive TINYINT(1) DEFAULT 0 AFTER requires_prescription";
        }
        if (!in_array('storage_temperature', $columns)) {
            $additions[] = "ADD COLUMN storage_temperature VARCHAR(100) NULL AFTER is_temperature_sensitive";
        }
        if (!in_array('is_controlled_substance', $columns)) {
            $additions[] = "ADD COLUMN is_controlled_substance TINYINT(1) DEFAULT 0 AFTER storage_temperature";
        }
        if (!in_array('product_photo', $columns)) {
            $additions[] = "ADD COLUMN product_photo VARCHAR(255) NULL AFTER is_controlled_substance";
        }
        if (!in_array('product_type', $columns)) {
            $additions[] = "ADD COLUMN product_type ENUM('brand','generic') DEFAULT 'generic' AFTER product_photo";
        }

        if (!empty($additions)) {
            $sql = "ALTER TABLE products " . implode(', ', $additions);
            $this->db->exec($sql);
        }
    }

    public function down(): void
    {
        // No rollback needed
    }
}
