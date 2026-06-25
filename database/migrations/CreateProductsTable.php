<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * ----------------------------------------------------------------
 * Products Table
 * ----------------------------------------------------------------
 * Produits pharmaceutiques.
 * ----------------------------------------------------------------
 */

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('products', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            name VARCHAR(255) NOT NULL,

            sku VARCHAR(100) UNIQUE,

            barcode VARCHAR(255),

            category VARCHAR(100),

            unit VARCHAR(50),

            description TEXT,

            cost_price DECIMAL(10,2) DEFAULT 0,

            selling_price DECIMAL(10,2) DEFAULT 0,

            minimum_stock INT DEFAULT 0,

            requires_prescription BOOLEAN DEFAULT FALSE,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ON UPDATE CURRENT_TIMESTAMP

        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $sql = Schema::drop('products');

        $this->db->exec($sql);
    }
}