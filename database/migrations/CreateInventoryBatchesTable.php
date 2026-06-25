<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * ----------------------------------------------------------------
 * Inventory Batches Table
 * ----------------------------------------------------------------
 * Gestion des lots pharmaceutiques.
 * ----------------------------------------------------------------
 */

class CreateInventoryBatchesTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('inventory_batches', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            product_id INT NOT NULL,

            batch_number VARCHAR(100),

            expiry_date DATE,

            quantity INT DEFAULT 0,

            supplier VARCHAR(255),

            purchase_price DECIMAL(10,2) DEFAULT 0,

            selling_price DECIMAL(10,2) DEFAULT 0,

            received_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $sql = Schema::drop('inventory_batches');

        $this->db->exec($sql);
    }
}