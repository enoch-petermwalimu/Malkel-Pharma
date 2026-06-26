<?php

namespace App\Modules\Settings\Controllers;

use App\Core\Controller;
use App\Modules\Settings\Services\SettingsService;

class SettingsController extends Controller
{
    protected SettingsService $settingsService;

    public function __construct()
    {
        $this->settingsService = new SettingsService();
    }

    /**
     * Afficher la page settings
     */
    public function index(): void
    {
        $settings = $this->settingsService->all();

        require dirname(__DIR__, 4)
            . '/resources/views/settings/index.php';
    }

    /**
     * Sauvegarder les paramètres
     */
    public function update(): void
    {
        $this->settingsService->set('pharmacy_name', $_POST['pharmacy_name'] ?? '');
        $this->settingsService->set('phone', $_POST['phone'] ?? '');
        $this->settingsService->set('email', $_POST['email'] ?? '');
        $this->settingsService->set('address', $_POST['address'] ?? '');
        $this->settingsService->set('primary_currency', $_POST['primary_currency'] ?? 'USD');
        $this->settingsService->set('exchange_rate', $_POST['exchange_rate'] ?? '3000');
        $this->settingsService->set('theme_name', $_POST['theme_name'] ?? 'medical-blue');
        $this->settingsService->set('invoice_prefix', $_POST['invoice_prefix'] ?? 'INV-');
        $this->settingsService->set('tax_rate', $_POST['tax_rate'] ?? '0');
        $this->settingsService->set('vat_rate', $_POST['vat_rate'] ?? '0');
        $this->settingsService->set('receipt_footer', $_POST['receipt_footer'] ?? 'Thank you for your purchase!');

        // Handle logo upload
        if (
            isset($_FILES['pharmacy_logo'])
            &&
            $_FILES['pharmacy_logo']['error'] === 0
        ) {
            $extension = pathinfo(
                $_FILES['pharmacy_logo']['name'],
                PATHINFO_EXTENSION
            );

            $fileName = 'logo_' . time() . '.' . $extension;

            $destination = dirname(__DIR__, 4)
                . '/public/uploads/logos/'
                . $fileName;

            move_uploaded_file(
                $_FILES['pharmacy_logo']['tmp_name'],
                $destination
            );

            $this->settingsService->set(
                'pharmacy_logo',
                '/uploads/logos/' . $fileName
            );
        }

        header('Location: /settings');
        exit;
    }
}
