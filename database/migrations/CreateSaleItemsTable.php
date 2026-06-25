<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * ----------------------------------------------------------------
 * Sale Items Table
 * ----------------------------------------------------------------
 * Produits vendus.
 * ----------------------------------------------------------------
 */

class CreateSaleItemsTable extends Migration
{
    /**
     * Migration UP
     */
    public function up(): void
    {
        $sql = Schema::create('sale_items', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            sale_id INT NOT NULL,

            product_id INT NOT NULL,

            batch_id INT NULL,

            quantity INT DEFAULT 1,

            unit_price DECIMAL(10,2) DEFAULT 0,

            total_price DECIMAL(10,2) DEFAULT 0,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

        ');

        $this->db->exec($sql);
    }

    /**
     * Migration DOWN
     */
    public function down(): void
    {
        $sql = Schema::drop('sale_items');

        $this->db->exec($sql);
    }
}