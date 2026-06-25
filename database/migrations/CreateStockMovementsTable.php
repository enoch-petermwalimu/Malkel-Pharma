<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * ----------------------------------------------------------------
 * Stock Movements Table
 * ----------------------------------------------------------------
 * Historique complet mouvements stock.
 * ----------------------------------------------------------------
 */

class CreateStockMovementsTable extends Migration
{
    /**
     * Migration UP
     */
    public function up(): void
    {
        $sql = Schema::create('stock_movements', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            product_id INT NOT NULL,

            batch_id INT NULL,

            movement_type VARCHAR(50) NOT NULL,

            quantity INT NOT NULL,

            previous_stock INT DEFAULT 0,

            new_stock INT DEFAULT 0,

            reference_type VARCHAR(100),

            reference_id INT NULL,

            notes TEXT,

            created_by INT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

        ');

        $this->db->exec($sql);
    }

    /**
     * Migration DOWN
     */
    public function down(): void
    {
        $sql = Schema::drop('stock_movements');

        $this->db->exec($sql);
    }
}