<?php

use App\Core\Migration;

class CreateCustomersModuleTable extends Migration
{
    public function up(): void
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS customers (
                id INT AUTO_INCREMENT PRIMARY KEY,

                name VARCHAR(255) NOT NULL,

                phone VARCHAR(50) NULL,

                email VARCHAR(255) NULL,

                address TEXT NULL,

                notes TEXT NULL,

                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    public function down(): void
    {
    }
}