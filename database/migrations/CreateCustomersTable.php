<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * -------------------------------------------------------------
 * Customers Table
 * -------------------------------------------------------------
 * Clients ERP
 * -------------------------------------------------------------
 */
class CreateCustomersTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('customers', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            full_name VARCHAR(255) NOT NULL,

            phone VARCHAR(50),

            email VARCHAR(150),

            address TEXT,

            loyalty_points INT DEFAULT 0,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $sql = Schema::drop('customers');

        $this->db->exec($sql);
    }
}