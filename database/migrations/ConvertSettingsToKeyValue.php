<?php

use App\Core\Migration;

/**
 * Convert old flat settings table to key-value store
 * This migration handles the transition from the old structure
 * where settings were stored as columns to the new key-value format.
 */
class ConvertSettingsToKeyValue extends Migration
{
    public function up(): void
    {
        // Check if old table exists with flat columns
        $result = $this->db->query("SHOW TABLES LIKE 'settings'");
        $tableExists = $result->rowCount() > 0;

        if (!$tableExists) {
            // New table already created by CreateSettingsTable migration
            return;
        }

        // Check if the table has the old flat structure (has pharmacy_name column)
        $columns = $this->db->query("SHOW COLUMNS FROM settings");
        $columnNames = [];
        foreach ($columns->fetchAll() as $col) {
            $columnNames[] = $col['Field'];
        }

        // If it already has setting_key, it's already converted
        if (in_array('setting_key', $columnNames)) {
            return;
        }

        // Old table has flat columns, need to convert
        // First, get the old data
        $oldData = $this->db->query("SELECT * FROM settings LIMIT 1")->fetch();

        if ($oldData) {
            // Drop old table
            $this->db->exec("DROP TABLE IF EXISTS settings");

            // Create new key-value table
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

            // Insert old data as key-value pairs
            $stmt = $this->db->prepare("
                INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value)
            ");

            $mappings = [
                'pharmacy_name' => 'pharmacy_name',
                'pharmacy_logo' => 'pharmacy_logo',
                'phone' => 'phone',
                'email' => 'email',
                'address' => 'address',
                'primary_currency' => 'primary_currency',
                'exchange_rate' => 'exchange_rate',
                'theme_name' => 'theme_name',
            ];

            foreach ($mappings as $oldKey => $newKey) {
                if (isset($oldData[$oldKey])) {
                    $stmt->execute([
                        'key' => $newKey,
                        'value' => $oldData[$oldKey]
                    ]);
                }
            }

            // Insert defaults for new settings that didn't exist in old table
            $defaults = [
                ['invoice_prefix', 'INV-'],
                ['tax_rate', '0'],
                ['vat_rate', '0'],
                ['receipt_footer', 'Thank you for your purchase!'],
            ];

            foreach ($defaults as $default) {
                $stmt->execute([
                    'key' => $default[0],
                    'value' => $default[1]
                ]);
            }
        } else {
            // Table exists but is empty, just recreate it
            $this->db->exec("DROP TABLE IF EXISTS settings");
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
        }
    }

    public function down(): void
    {
        // No rollback needed
    }
}
<?php

use App\Core\Migration;

/**
 * Convert old flat settings table to key-value store
 * This migration handles the transition from the old structure
 * where settings were stored as columns to the new key-value format.
 */
class ConvertSettingsToKeyValue extends Migration
{
    public function up(): void
    {
        // Check if old table exists with flat columns
        $result = $this->db->query("SHOW TABLES LIKE 'settings'");
        $tableExists = $result->rowCount() > 0;

        if (!$tableExists) {
            // New table already created by CreateSettingsTable migration
            return;
        }

        // Check if the table has the old flat structure (has pharmacy_name column)
        $columns = $this->db->query("SHOW COLUMNS FROM settings");
        $columnNames = [];
        foreach ($columns->fetchAll() as $col) {
            $columnNames[] = $col['Field'];
        }

        // If it already has setting_key, it's already converted
        if (in_array('setting_key', $columnNames)) {
            return;
        }

        // Old table has flat columns, need to convert
        // First, get the old data
        $oldData = $this->db->query("SELECT * FROM settings LIMIT 1")->fetch();

        if ($oldData) {
            // Drop old table
            $this->db->exec("DROP TABLE IF EXISTS settings");

            // Create new key-value table
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

            // Insert old data as key-value pairs
            $stmt = $this->db->prepare("
                INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value)
            ");

            $mappings = [
                'pharmacy_name' => 'pharmacy_name',
                'pharmacy_logo' => 'pharmacy_logo',
                'phone' => 'phone',
                'email' => 'email',
                'address' => 'address',
                'primary_currency' => 'primary_currency',
                'exchange_rate' => 'exchange_rate',
                'theme_name' => 'theme_name',
            ];

            foreach ($mappings as $oldKey => $newKey) {
                if (isset($oldData[$oldKey])) {
                    $stmt->execute([
                        'key' => $newKey,
                        'value' => $oldData[$oldKey]
                    ]);
                }
            }

            // Insert defaults for new settings that didn't exist in old table
            $defaults = [
                ['invoice_prefix', 'INV-'],
                ['tax_rate', '0'],
                ['vat_rate', '0'],
                ['receipt_footer', 'Thank you for your purchase!'],
            ];

            foreach ($defaults as $default) {
                $stmt->execute([
                    'key' => $default[0],
                    'value' => $default[1]
                ]);
            }
        } else {
            // Table exists but is empty, just recreate it
            $this->db->exec("DROP TABLE IF EXISTS settings");
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
        }
    }

    public function down(): void
    {
        // No rollback needed
    }
}
