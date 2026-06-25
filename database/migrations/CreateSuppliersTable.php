<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * Suppliers table
 */
class CreateSuppliersTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('suppliers', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            company_name VARCHAR(255) NOT NULL,

            contact_name VARCHAR(255),

            phone VARCHAR(50),

            email VARCHAR(150),

            address TEXT,

            notes TEXT,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $this->db->exec(
            Schema::drop('suppliers')
        );
    }
}