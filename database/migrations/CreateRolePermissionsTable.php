<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * ----------------------------------------------------------------
 * Role Permissions Pivot Table
 * ----------------------------------------------------------------
 * Liaison rôles <-> permissions
 * ----------------------------------------------------------------
 */

class CreateRolePermissionsTable extends Migration
{
    public function up(): void
    {
        $sql = Schema::create('role_permissions', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            role_id INT NOT NULL,

            permission_id INT NOT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

        ');

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $sql = Schema::drop('role_permissions');

        $this->db->exec($sql);
    }
}