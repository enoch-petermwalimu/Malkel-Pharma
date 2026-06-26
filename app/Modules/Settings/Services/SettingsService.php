<?php

namespace App\Modules\Settings\Services;

use App\Modules\Settings\Models\Settings;

/**
 * Settings Service
 * 
 * Centralized service for accessing application settings.
 */
class SettingsService
{
    protected Settings $model;
    protected ?array $cache = null;

    public function __construct()
    {
        $this->model = new Settings();
    }

    /**
     * Get all settings as key-value array (cached per request)
     */
    public function all(): array
    {
        if ($this->cache === null) {
            $this->cache = $this->model->all();
        }
        return $this->cache;
    }

    /**
     * Get a single setting value
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $all = $this->all();
        return $all[$key] ?? $default;
    }

    /**
     * Set a single setting value
     */
    public function set(string $key, mixed $value): bool
    {
        $result = $this->model->set($key, $value);
        // Invalidate cache
        $this->cache = null;
        return $result;
    }

    /**
     * Get pharmacy name
     */
    public function pharmacyName(): string
    {
        return $this->get('pharmacy_name', 'MARKEL PHARMA');
    }

    /**
     * Get pharmacy logo URL
     */
    public function pharmacyLogo(): string
    {
        return $this->get('pharmacy_logo', '/assets/images/logo.png');
    }

    /**
     * Get pharmacy phone
     */
    public function phone(): string
    {
        return $this->get('phone', '');
    }

    /**
     * Get pharmacy email
     */
    public function email(): string
    {
        return $this->get('email', '');
    }

    /**
     * Get pharmacy address
     */
    public function address(): string
    {
        return $this->get('address', '');
    }

    /**
     * Get primary currency
     */
    public function primaryCurrency(): string
    {
        return $this->get('primary_currency', 'USD');
    }

    /**
     * Get exchange rate (USD to local)
     */
    public function exchangeRate(): float
    {
        return (float) $this->get('exchange_rate', '3000');
    }

    /**
     * Get theme name
     */
    public function themeName(): string
    {
        return $this->get('theme_name', 'medical-blue');
    }

    /**
     * Get invoice prefix
     */
    public function invoicePrefix(): string
    {
        return $this->get('invoice_prefix', 'INV-');
    }

    /**
     * Get tax rate (percentage)
     */
    public function taxRate(): float
    {
        return (float) $this->get('tax_rate', '0');
    }

    /**
     * Get VAT rate (percentage)
     */
    public function vatRate(): float
    {
        return (float) $this->get('vat_rate', '0');
    }

    /**
     * Get receipt footer text
     */
    public function receiptFooter(): string
    {
        return $this->get('receipt_footer', 'Thank you for your purchase!');
    }
}
