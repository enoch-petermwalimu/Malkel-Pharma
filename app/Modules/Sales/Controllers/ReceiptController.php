<?php

namespace App\Modules\Sales\Controllers;

use App\Core\Controller;
use App\Modules\Sales\Repositories\SaleRepository;

class ReceiptController extends Controller
{
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

            exit('Vente introuvable');
        }

        $items =
            $repository->saleDetails(
                $saleId
            );

        $this->view(
            'sales.receipt',
            [
                'sale' => $sale,
                'items' => $items
            ]
        );
    }
}