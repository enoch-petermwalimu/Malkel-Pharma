<?php

use App\Core\Migration;

class CreateSettingsTable extends Migration
{
    public function up(): void
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS settings (
                id INT AUTO_INCREMENT PRIMARY KEY,

                pharmacy_name VARCHAR(255) NOT NULL,

                pharmacy_logo VARCHAR(255) NULL,

                phone VARCHAR(50) NULL,

                email VARCHAR(255) NULL,

                address TEXT NULL,

                primary_currency VARCHAR(10) DEFAULT 'USD',

                exchange_rate DECIMAL(12,2) DEFAULT 3000,

                theme_name VARCHAR(100) DEFAULT 'medical-blue',

                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                updated_at TIMESTAMP NULL
            )
        ");
    }

    public function down(): void {}
}