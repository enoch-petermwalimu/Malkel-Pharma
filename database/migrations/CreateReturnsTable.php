<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * ============================================================
 * Returns
 * ============================================================
 */
class CreateReturnsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('returns', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            return_type VARCHAR(100) NOT NULL,

            reference_type VARCHAR(100) NULL,

            reference_id INT NULL,

            customer_id INT NULL,

            supplier_id INT NULL,

            total_amount DECIMAL(10,2) DEFAULT 0,

            refund_type VARCHAR(100) NULL,

            reason TEXT NOT NULL,

            processed_by INT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('returns')
        );
    }
}