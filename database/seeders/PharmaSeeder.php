<?php

use App\Core\Database;

class PharmaSeeder
{
    public static function run(): void
    {
        $db = Database::connect();

        /**
         * Categories
         */
        $categories = [
            'Spécialité',
            'Générique',
            'Parapharmacie',
            'Consommable médical',
            'Complément alimentaire'
        ];

        foreach ($categories as $category) {

            $stmt = $db->prepare("
                INSERT INTO categories (name)
                VALUES (:name)
            ");

            $stmt->execute([
                'name' => $category
            ]);
        }

        /**
         * Dosage forms
         */
        $forms = [
            'Comprimé',
            'Capsule',
            'Gélule',
            'Sirop',
            'Injectable',
            'Suppositoire',
            'Ovule',
            'Crème',
            'Gel',
            'Spray',
            'Collyre',
            'Solution buvable',
            'Sachet',
            'Ampoule'
        ];

        foreach ($forms as $form) {

            $stmt = $db->prepare("
                INSERT INTO dosage_forms (name)
                VALUES (:name)
            ");

            $stmt->execute([
                'name' => $form
            ]);
        }

        /**
         * Packaging units
         */
        $units = [
            ['Boîte', 'bt'],
            ['Plaquette', 'plq'],
            ['Flacon', 'fl'],
            ['Tube', 'tb'],
            ['Ampoule', 'amp'],
            ['Sachet', 'scht'],
            ['Pièce', 'pc']
        ];

        foreach ($units as $unit) {

            $stmt = $db->prepare("
                INSERT INTO packaging_units
                (
                    name,
                    abbreviation
                )
                VALUES
                (
                    :name,
                    :abbr
                )
            ");

            $stmt->execute([
                'name' => $unit[0],
                'abbr' => $unit[1]
            ]);
        }

            $sqlFile = __DIR__
                . '/../data/pharmaceutical_catalog.sql';

            if (file_exists($sqlFile)) {

                $sql = file_get_contents($sqlFile);

                $db->exec($sql);

                echo "Pharmaceutical catalog imported.\n";
            }

        echo "Pharma seed complete.\n";
    }
}