<?php

use App\Core\Migration;

class CreateSettingsTable extends Migration
{
    public function up(): void
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS settings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                setting_key VARCHAR(100) NOT NULL UNIQUE,
                setting_value TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_setting_key (setting_key)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        // Insert default settings
        $defaults = [
            ['pharmacy_name', 'MARKEL PHARMA'],
            ['pharmacy_logo', '/assets/images/logo.png'],
            ['phone', ''],
            ['email', ''],
            ['address', ''],
            ['primary_currency', 'USD'],
            ['exchange_rate', '3000'],
            ['theme_name', 'medical-blue'],
            ['invoice_prefix', 'INV-'],
            ['tax_rate', '0'],
            ['vat_rate', '0'],
            ['receipt_footer', 'Thank you for your purchase!'],
        ];

        $stmt = $this->db->prepare("
            INSERT IGNORE INTO settings (setting_key, setting_value) VALUES (:key, :value)
        ");

        foreach ($defaults as $default) {
            $stmt->execute(['key' => $default[0], 'value' => $default[1]]);
        }
    }

    public function down(): void
    {
        $this->db->exec("DROP TABLE IF EXISTS settings");
    }
}
