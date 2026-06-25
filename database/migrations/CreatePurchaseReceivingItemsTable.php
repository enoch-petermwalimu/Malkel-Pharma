<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * Receiving items
 */
class CreatePurchaseReceivingItemsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('purchase_receiving_items', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            receiving_id INT NOT NULL,

            purchase_item_id INT NOT NULL,

            quantity_received INT NOT NULL,

            batch_number VARCHAR(100),

            expiry_date DATE,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('purchase_receiving_items')
        );
    }
}