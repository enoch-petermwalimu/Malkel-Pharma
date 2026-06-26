<?php

namespace App\Modules\Reports\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Modules\Sales\Repositories\SaleRepository;
use App\Modules\Purchases\Repositories\PurchaseRepository;

/**
 * ============================================================
 * Report Controller
 * ============================================================
 * Financial statistics and reporting
 * ============================================================
 */
class ReportController extends Controller
{
    protected SaleRepository $salesRepo;
    protected PurchaseRepository $purchaseRepo;

    public function __construct()
    {
        $this->salesRepo = new SaleRepository();
        $this->purchaseRepo = new PurchaseRepository();
    }

    /**
     * Financial dashboard
     */
    public function index(): void
    {
        $this->view('reports.index', [
            /*
             * Revenue
             */
            'todayRevenue' => $this->salesRepo->todayRevenue(),
            'totalRevenue' => $this->salesRepo->totalRevenue(),
            'revenue3Days' => $this->salesRepo->revenueLast3Days(),
            'revenue7Days' => $this->salesRepo->revenueLast7Days(),
            'revenue30Days' => $this->salesRepo->revenueDays(30),

            /*
             * Sales
             */
            'salesToday' => count($this->salesRepo->todaySales()),
            'totalSalesCount' => $this->salesRepo->totalSalesCount(),
            'latestSales' => $this->salesRepo->latestSales(10),

            /*
             * Products
             */
            'topProducts' => $this->salesRepo->topProducts(),

            /*
             * Purchases
             */
            'totalPurchases' => count($this->purchaseRepo->allPurchases()),
            'purchaseTotal' => $this->getPurchaseTotal(),
        ]);
    }

    /**
     * Get total purchase amount
     */
    protected function getPurchaseTotal(): float
    {
        $purchases = $this->purchaseRepo->allPurchases();
        $total = 0;
        foreach ($purchases as $purchase) {
            $total += (float) ($purchase['total'] ?? 0);
        }
        return $total;
    }

    /**
     * Revenue between dates (JSON)
     */
    public function revenueBetween(): void
    {
        $request = new Request();
        $data = $request->body();

        $start = $data['start'] ?? date('Y-m-d', strtotime('-30 days'));
        $end = $data['end'] ?? date('Y-m-d');

        $revenue = $this->salesRepo->revenueBetween($start, $end);

        $this->json([
            'success' => true,
            'revenue' => $revenue,
            'start' => $start,
            'end' => $end
        ]);
    }
}
