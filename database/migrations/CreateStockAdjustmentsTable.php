<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * ============================================================
 * Stock Adjustments
 * ============================================================
 * Audit corrections
 * ============================================================
 */
class CreateStockAdjustmentsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('stock_adjustments', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            product_id INT NOT NULL,

            batch_id INT NULL,

            adjustment_type VARCHAR(100) NOT NULL,

            system_quantity INT NOT NULL,

            physical_quantity INT NOT NULL,

            difference_quantity INT NOT NULL,

            reason TEXT NOT NULL,

            adjusted_by INT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('stock_adjustments')
        );
    }
}