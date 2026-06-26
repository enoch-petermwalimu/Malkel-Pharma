<?php

namespace App\Modules\Sales\Controllers;

use App\Core\Controller;
use App\Modules\Sales\Repositories\SaleRepository;

/**
 * ============================================================
 * Sales History Controller
 * ============================================================
 */
class SalesHistoryController extends Controller
{
    public function index(): void
    {
        $repository =
            new SaleRepository();

        $sales =
            $repository->history();

        $this->view(
            'sales.history',
            [
                'sales' => $sales
            ]
        );
    }

    public function show(): void
    {
        $saleId =
            (int) ($_GET['id'] ?? 0);

        $repository =
            new SaleRepository();

        $sale =
            $repository->find(
                $saleId
            );

        if (!$sale) {

            exit(
                'Sale not found'
            );
        }

        $items =
            $repository->saleDetails(
                $saleId
            );

        $this->view(
            'sales.show',
            [
                'sale' => $sale,
                'items' => $items
            ]
        );
    }
}