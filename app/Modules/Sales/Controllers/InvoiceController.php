<?php

namespace App\Modules\Sales\Controllers;

use App\Core\Controller;
use App\Modules\Sales\Services\InvoiceService;

class InvoiceController
    extends Controller
{
    protected InvoiceService $service;

    public function __construct()
    {
        $this->service =
            new InvoiceService();
    }

    public function pdf(): void
    {
        $saleId =
            (int) ($_GET['id'] ?? 0);

        $this->service
            ->generatePdf(
                $saleId
            );
    }
}