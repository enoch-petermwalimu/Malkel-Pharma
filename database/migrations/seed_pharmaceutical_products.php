<?php

use App\Core\Database;

class SeedPharmaceuticalProducts
{
    public static function run(): void
    {
        $db = Database::connect();

        $sql = file_get_contents(
            __DIR__ . '/../data/pharmaceutical_catalog.sql'
        );

        $db->exec($sql);

        echo "Pharmaceutical products seeded successfully.\n";
    }
}