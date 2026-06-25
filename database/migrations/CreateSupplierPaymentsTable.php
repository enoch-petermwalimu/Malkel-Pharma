<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * Supplier payments
 */
class CreateSupplierPaymentsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('supplier_payments', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            purchase_id INT NOT NULL,

            payment_method VARCHAR(100),

            amount DECIMAL(10,2) NOT NULL,

            payment_reference VARCHAR(255),

            notes TEXT,

            paid_by INT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('supplier_payments')
        );
    }
}