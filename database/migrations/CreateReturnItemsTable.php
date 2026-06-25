<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * Return items
 */
class CreateReturnItemsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('return_items', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            return_id INT NOT NULL,

            product_id INT NOT NULL,

            batch_id INT NULL,

            quantity INT NOT NULL,

            unit_price DECIMAL(10,2) DEFAULT 0,

            restocked TINYINT(1) DEFAULT 0,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('return_items')
        );
    }
}