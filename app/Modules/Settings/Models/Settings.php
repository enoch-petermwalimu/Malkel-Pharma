<?php

namespace App\Modules\Settings\Models;

use App\Core\Model;

/**
 * Settings Model
 * 
 * Represents the settings table (key-value store).
 */
class Settings extends Model
{
    protected string $table = 'settings';

    /**
     * Get a setting value by key
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $statement = $this->db->prepare(
            "SELECT setting_value FROM {$this->table} WHERE setting_key = :key LIMIT 1"
        );
        $statement->execute(['key' => $key]);
        $row = $statement->fetch();

        return $row ? $row['setting_value'] : $default;
    }

    /**
     * Set a setting value
     */
    public function set(string $key, mixed $value): bool
    {
        $statement = $this->db->prepare(
            "INSERT INTO {$this->table} (setting_key, setting_value) 
             VALUES (:key, :value) 
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)"
        );
        return $statement->execute(['key' => $key, 'value' => $value]);
    }

    /**
     * Get all settings as key-value array
     */
    public function all(): array
    {
        $statement = $this->db->query("SELECT setting_key, setting_value FROM {$this->table}");
        $rows = $statement->fetchAll();
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }
}
<?php

namespace App\Modules\Settings\Models;

use App\Core\Model;

/**
 * Settings Model
 * 
 * Represents the settings table (key-value store).
 */
class Settings extends Model
{
    protected string $table = 'settings';

    /**
     * Get a setting value by key
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $statement = $this->db->prepare(
            "SELECT setting_value FROM {$this->table} WHERE setting_key = :key LIMIT 1"
        );
        $statement->execute(['key' => $key]);
        $row = $statement->fetch();

        return $row ? $row['setting_value'] : $default;
    }

    /**
     * Set a setting value
     */
    public function set(string $key, mixed $value): bool
    {
        $statement = $this->db->prepare(
            "INSERT INTO {$this->table} (setting_key, setting_value) 
             VALUES (:key, :value) 
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)"
        );
        return $statement->execute(['key' => $key, 'value' => $value]);
    }

    /**
     * Get all settings as key-value array
     */
    public function all(): array
    {
        $statement = $this->db->query("SELECT setting_key, setting_value FROM {$this->table}");
        $rows = $statement->fetchAll();
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }
}
