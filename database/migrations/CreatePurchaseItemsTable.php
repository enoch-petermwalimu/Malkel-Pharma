<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * Purchase items
 */
class CreatePurchaseItemsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('purchase_items', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            purchase_id INT NOT NULL,

            product_id INT NOT NULL,

            quantity INT NOT NULL,

            unit_cost DECIMAL(10,2) DEFAULT 0,

            total_cost DECIMAL(10,2) DEFAULT 0,

            expiry_date DATE NULL,

            batch_number VARCHAR(100),

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('purchase_items')
        );
    }
}