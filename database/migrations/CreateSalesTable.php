<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * ----------------------------------------------------------------
 * Sales Table
 * ----------------------------------------------------------------
 * Ventes principales.
 * ----------------------------------------------------------------
 */

class CreateSalesTable extends Migration
{
    /**
     * Migration UP
     */
    public function up(): void
    {
        $sql = Schema::create('sales', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            invoice_number VARCHAR(100) UNIQUE,

            customer_id INT NULL,

            user_id INT NULL,

            subtotal DECIMAL(10,2) DEFAULT 0,

            discount DECIMAL(10,2) DEFAULT 0,

            tax DECIMAL(10,2) DEFAULT 0,

            total DECIMAL(10,2) DEFAULT 0,

            payment_status VARCHAR(50) DEFAULT "pending",

            sale_status VARCHAR(50) DEFAULT "completed",

            notes TEXT,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

        ');

        $this->db->exec($sql);
    }

    /**
     * Migration DOWN
     */
    public function down(): void
    {
        $sql = Schema::drop('sales');

        $this->db->exec($sql);
    }
}