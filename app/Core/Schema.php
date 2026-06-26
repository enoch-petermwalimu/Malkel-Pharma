<?php

namespace App\Core;

/**
 * Schema helper
 */
class Schema
{
    public static function create(
        string $table,
        string $definition
    ): string {
        return "
            CREATE TABLE IF NOT EXISTS {$table}
            (
                {$definition}
            )
        ";
    }

    public static function drop(
        string $table
    ): string {
        return "
            DROP TABLE IF EXISTS {$table}
        ";
    }
}