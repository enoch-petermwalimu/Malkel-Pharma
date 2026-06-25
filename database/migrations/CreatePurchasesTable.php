<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * Purchases
 */
class CreatePurchasesTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('purchases', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            purchase_number VARCHAR(100) UNIQUE,

            supplier_id INT NOT NULL,

            subtotal DECIMAL(10,2) DEFAULT 0,

            tax DECIMAL(10,2) DEFAULT 0,

            discount DECIMAL(10,2) DEFAULT 0,

            total DECIMAL(10,2) DEFAULT 0,

            payment_status VARCHAR(50) DEFAULT "pending",

            notes TEXT,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('purchases')
        );
    }
}