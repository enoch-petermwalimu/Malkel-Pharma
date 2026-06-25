<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * ----------------------------------------------------------------
 * Permissions Table Migration
 * ----------------------------------------------------------------
 * Permissions système.
 * ----------------------------------------------------------------
 */

class CreatePermissionsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('permissions', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            name VARCHAR(150) UNIQUE NOT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $sql = Schema::drop('permissions');

        $this->db->exec($sql);
    }
}