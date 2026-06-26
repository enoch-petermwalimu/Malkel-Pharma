<?php

namespace App\Core;

use PDO;

/**
 * ----------------------------------------------------------------
 * Base Migration Class
 * ----------------------------------------------------------------
 * Cette classe sert de base pour toutes les migrations.
 * Chaque migration héritera de cette classe.
 * ----------------------------------------------------------------
 */

abstract class Migration
{
    /**
     * Instance PDO
     */
    protected PDO $db;

    /**
     * Initialisation connexion DB
     */
    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Méthode exécutée lors du migrate
     */
    abstract public function up(): void;

    /**
     * Méthode exécutée lors du rollback
     */
    abstract public function down(): void;
}