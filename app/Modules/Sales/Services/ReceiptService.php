<?php

namespace App\Modules\Sales\Services;

use App\Modules\Settings\Services\SettingsService;

/**
 * -------------------------------------------------------------
 * Receipt Service
 * -------------------------------------------------------------
 */
class ReceiptService
{
    protected SettingsService $settings;

    public function __construct()
    {
        $this->settings = new SettingsService();
    }

    public function generate(array $sale): string
    {
        $pharmacyName = $this->settings->pharmacyName();
        $phone = $this->settings->phone();
        $email = $this->settings->email();
        $address = $this->settings->address();
        $footer = $this->settings->receiptFooter();

        $receipt = "
            {$pharmacyName}
            ----------------------
            Invoice: {$sale['invoice_number']}
            Total: {$sale['total']}
        ";

        if ($phone) {
            $receipt .= "\nPhone: {$phone}";
        }
        if ($email) {
            $receipt .= "\nEmail: {$email}";
        }
        if ($address) {
            $receipt .= "\nAddress: {$address}";
        }

        $receipt .= "\n{$footer}";

        return $receipt;
    }
}
