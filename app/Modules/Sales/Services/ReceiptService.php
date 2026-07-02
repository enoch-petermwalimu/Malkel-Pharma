<?php

namespace App\Modules\Sales\Services;

/**
 * -------------------------------------------------------------
 * Receipt Service
 * -------------------------------------------------------------
 */
class ReceiptService
{
    public function generate(array $sale): string
    {
        return sprintf(
            "MARKEL PHARMA\nInvoice: %s\nTotal: %s\nThank you",
            $sale['invoice_number'] ?? '',
            $sale['total'] ?? ''
        );
    }
}
