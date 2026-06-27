<?php

namespace App\Modules\Settings\Controllers;

use App\Core\Controller;
use App\Core\Database;

class SettingsController extends Controller
{
    /**
     * Afficher la page settings
     */
    public function index(): void
    {
        $db = Database::connect();

        $stmt = $db->query("
            SELECT
                setting_key,
                setting_value
            FROM settings
        ");

        $settings = [];

        foreach ($stmt->fetchAll() as $row) {

            $settings[
                $row['setting_key']
            ] = $row['setting_value'];
        }

        require dirname(__DIR__, 4)
            . '/resources/views/settings/index.php';
    }

    /**
     * Sauvegarder les paramètres
     */
    public function update(): void
    {
        $this->saveSetting(
            'pharmacy_name',
            $_POST['pharmacy_name'] ?? ''
        );

        $this->saveSetting(
            'phone',
            $_POST['phone'] ?? ''
        );

        $this->saveSetting(
            'email',
            $_POST['email'] ?? ''
        );

        $this->saveSetting(
            'address',
            $_POST['address'] ?? ''
        );

        $this->saveSetting(
            'primary_currency',
            $_POST['primary_currency'] ?? 'USD'
        );

        $this->saveSetting(
            'exchange_rate',
            $_POST['exchange_rate'] ?? '3000'
        );

        $this->saveSetting(
            'theme_name',
            $_POST['theme_name'] ?? 'medical-blue'
        );

        header('Location: /settings');
        exit;

        if (
            isset($_FILES['pharmacy_logo'])
            &&
            $_FILES['pharmacy_logo']['error'] === 0
        ) {

            $extension = pathinfo(
            $_FILES['pharmacy_logo']['name'],
            PATHINFO_EXTENSION
            );

            $fileName =
                'logo_' .
                time() .
                '.' .
                $extension;

            $destination =
                dirname(__DIR__, 4)
                . '/public/uploads/logos/'
                . $fileName;

            move_uploaded_file(
                $_FILES['pharmacy_logo']['tmp_name'],
                $destination
            );

            $this->saveSetting(
                'pharmacy_logo',
                '/uploads/logos/' . $fileName
            );
        }
    }

    /**
     * Insère ou met à jour un paramètre
     */
    private function saveSetting(
        string $key,
        string $value
    ): void
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO settings
            (
                setting_key,
                setting_value
            )
            VALUES
            (
                :setting_key,
                :setting_value
            )
            ON DUPLICATE KEY UPDATE
            setting_value = VALUES(setting_value)
        ");

        $stmt->execute([
            'setting_key' => $key,
            'setting_value' => $value
        ]);
    }
}