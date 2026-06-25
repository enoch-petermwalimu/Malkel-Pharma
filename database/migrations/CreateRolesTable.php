<?php

use App\Core\Migration;
use App\Core\Schema;

/**
 * ----------------------------------------------------------------
 * Roles Table Migration
 * ----------------------------------------------------------------
 * Gestion des rôles utilisateurs.
 * ----------------------------------------------------------------
 */

class CreateRolesTable extends Migration
{
    /**
     * Création table
     */
    public function up(): void
    {
        $sql = Schema::create('roles', '

            id INT AUTO_INCREMENT PRIMARY KEY,

            name VARCHAR(100) UNIQUE NOT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

        ');

        $this->db->exec($sql);
    }

    /**
     * Rollback
     */
    public function down(): void
    {
        $sql = Schema::drop('roles');

        $this->db->exec($sql);
    }
}