<?php

namespace App\Modules\Sales\Controllers;

use App\Core\Controller;
use App\Core\Request;

use App\Modules\Sales\Services\SaleService;
use App\Modules\Sales\Repositories\SaleRepository;

/**
 * -------------------------------------------------------------
 * Sale Controller
 * -------------------------------------------------------------
 */
class SaleController extends Controller
{
    protected SaleService $service;
    protected SaleRepository $repository;

    public function __construct()
    {
        $this->service = new SaleService();
        $this->repository = new SaleRepository();
    }

    /**
     * Sales list
     */
    public function index(): void
    {
        $sales = $this->repository->history();

        $this->view('sales.index', [
            'sales' => $sales
        ]);
    }

    /**
     * Sale detail
     */
    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            $this->redirect('/sales/history');
            return;
        }

        $sale = $this->repository->find($id);

        if (!$sale) {
            $this->redirect('/sales/history');
            return;
        }

        $items = $this->repository->saleItems($id);

        $this->view('sales.show', [
            'sale' => $sale,
            'items' => $items
        ]);
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

    $sale =
        $this->repository->findByInvoice($invoice);

    if (!$sale) {
        $this->json([
            'success' => false
        ]);
        return;
    }

    $items =
        $this->repository->saleItems(
            (int) $sale['id']
        );

    $this->json([
        'success' => true,
        'sale' => $sale,
        'items' => $items
    ]);
}
}
