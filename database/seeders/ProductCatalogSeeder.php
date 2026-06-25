<?php

use App\Core\Database;

class ProductCatalogSeeder
{
    public static function run(): void
    {
        $db = Database::connect();

        $sql = file_get_contents(
            dirname(__DIR__)
            . '/data/pharmaceutical_catalog.sql'
        );

        $db->exec($sql);

        echo "Product catalog seeded.\n";
    }
}