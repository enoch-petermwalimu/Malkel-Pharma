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
        return "
            MARKEL PHARMA
            ----------------------
            Invoice: {$sale['invoice_number']}
            Total: {$sale['total']}
            Thank you
        ";
    }
}