<?php

namespace App\Core;

/**
 * ----------------------------------------------------------------
 * Migrator
 * ----------------------------------------------------------------
 * Exécute toutes les migrations automatiquement.
 * ----------------------------------------------------------------
 */

class Migrator
{
    /**
     * Dossier migrations
     */
    protected string $migrationPath;

    public function __construct()
    {
        $this->migrationPath =
            dirname(__DIR__, 2)
            . '/database/migrations/';
    }

    /**
     * Lance les migrations
     */
    public function migrate(): void
    {
        $files = scandir($this->migrationPath);

        foreach ($files as $file) {

            if (
                $file === '.' ||
                $file === '..'
            ) {
                continue;
            }

            require_once $this->migrationPath . $file;

            $className = pathinfo($file, PATHINFO_FILENAME);

            $migration = new $className();

            $migration->up();

            echo "Migrated: {$className}<br>";
        }
    }
}