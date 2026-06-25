<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * Purchase receivings
 */
class CreatePurchaseReceivingsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('purchase_receivings', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            purchase_id INT NOT NULL,

            received_by INT NULL,

            notes TEXT,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('purchase_receivings')
        );
    }
}   