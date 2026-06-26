<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * ============================================================
 * Database Core
 * ============================================================
 */
class Database
{
    protected static ?PDO $connection = null;

    /**
     * Connect to database
     */
    public static function connect(
        bool $withoutDatabase = false
    ): PDO {
        if (self::$connection && !$withoutDatabase) {
            return self::$connection;
        }

        $host = env('DB_HOST', '127.0.0.1');
        $port = env('DB_PORT', '3306');
        $db   = env('DB_DATABASE', 'markel_pharma');
        $user = env('DB_USERNAME', 'root');
        $pass = env('DB_PASSWORD', 'Kool2004');

        $dsn = $withoutDatabase
            ? "mysql:host={$host};port={$port};charset=utf8mb4"
            : "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

        try {
            $pdo = new PDO(
                $dsn,
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE =>
                        PDO::ERRMODE_EXCEPTION,

                    PDO::ATTR_DEFAULT_FETCH_MODE =>
                        PDO::FETCH_ASSOC
                ]
            );

            if (!$withoutDatabase) {
                self::$connection = $pdo;
            }

            return $pdo;

        } catch (PDOException $e) {
            die('DB ERROR: ' . $e->getMessage());
        }
    }

    /**
     * Create database
     */
    public static function createDatabase(): void
    {
        $db = env('DB_DATABASE', 'markel_pharma');

        $pdo = self::connect(true);

        $pdo->exec(
            "CREATE DATABASE IF NOT EXISTS `{$db}`
             CHARACTER SET utf8mb4
             COLLATE utf8mb4_unicode_ci"
        );

        echo "Database created: {$db}\n";
    }
}