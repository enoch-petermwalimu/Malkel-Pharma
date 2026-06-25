<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * ----------------------------------------------------------------
 * Sale Payments Table
 * ----------------------------------------------------------------
 * Paiements ventes.
 * ----------------------------------------------------------------
 */

class CreateSalePaymentsTable extends Migration
{
    /**
     * Migration UP
     */
    public function up(): void
    {
        $sql = Schema::create('sale_payments', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            sale_id INT NOT NULL,

            payment_method VARCHAR(100),

            amount DECIMAL(10,2) DEFAULT 0,

            transaction_reference VARCHAR(255),

            payment_status VARCHAR(50) DEFAULT "paid",

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

        ');

        $this->db->exec($sql);
    }

    /**
     * Migration DOWN
     */
    public function down(): void
    {
        $sql = Schema::drop('sale_payments');

        $this->db->exec($sql);
    }
}