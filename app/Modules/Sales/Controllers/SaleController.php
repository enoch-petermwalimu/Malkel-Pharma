<?php

namespace App\Modules\Sales\Controllers;

use App\Core\Controller;
use App\Core\Request;

use App\Modules\Sales\Services\SaleService;

/**
 * -------------------------------------------------------------
 * Sale Controller
 * -------------------------------------------------------------
 */
class SaleController extends Controller
{
    protected SaleService $service;

    public function __construct()
    {
        $this->service = new SaleService();
    }

    /**
     * Checkout API
     */
    public function checkout(): void
    {
        $request = new Request();

        $data = $request->body();

        $result =
            $this->service->createSale($data);

        if (!$result) {
            $this->json([
                'success' => false,
                'message' => 'Checkout failed'
            ], 500);

            return;
        }

        $this->json([

            'success' => true,

            'sale_id' =>
                $result['sale_id'],

            'invoice_number' =>
                $result['invoice_number']
        ]);
    }

    /**
 * Invoice lookup
 */
public function invoiceLookup(): void
{
    $invoice =
        $_GET['invoice'] ?? '';

    $repository =
        new \App\Modules\Sales\Repositories\SaleRepository();

    $sale =
        $repository->findByInvoice($invoice);

    if (!$sale) {
        $this->json([
            'success' => false
        ]);
        return;
    }

    $items =
        $repository->saleItems(
            (int) $sale['id']
        );

    $this->json([
        'success' => true,
        'sale' => $sale,
        'items' => $items
    ]);
}
}