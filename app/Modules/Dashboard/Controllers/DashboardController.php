<?php

namespace App\Modules\Dashboard\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Modules\Sales\Repositories\SaleRepository;
use App\Modules\Inventory\Repositories\InventoryRepository;

/**
 * ============================================================
 * Dashboard Controller
 * ============================================================
 */
class DashboardController extends Controller
{
    public function index(): void
    {
        $salesRepo = new SaleRepository();
        $inventoryRepo = new InventoryRepository();

        $customersCount = 0;
        $productsCount = 0;
        $usersCount = 0;

        try {
            $db = Database::connect();

            $customersCount = (int) $db
                ->query("SELECT COUNT(*) total FROM customers")
                ->fetch()['total'];

            $productsCount = (int) $db
                ->query("SELECT COUNT(*) total FROM products")
                ->fetch()['total'];

            $usersCount = (int) $db
                ->query("SELECT COUNT(*) total FROM users")
                ->fetch()['total'];

        } catch (\Throwable $e) {
            // Dashboard must continue working
        }

        $salesToday = count($salesRepo->todaySales());

        $dailySales = $salesRepo->dailySalesLast7Days();

        $this->view('dashboard.index', [
            /*
             * Revenue
             */
            'todayRevenue' => $salesRepo->todayRevenue(),
            'totalRevenue' => $salesRepo->totalRevenue(),
            'revenue3Days' => $salesRepo->revenueLast3Days(),
            'revenue7Days' => $salesRepo->revenueLast7Days(),
            'revenue30Days' => $salesRepo->revenueDays(30),

            /*
             * Sales
             */
            'salesToday' => $salesToday,
            'totalSalesCount' => $salesRepo->totalSalesCount(),
            'latestSales' => $salesRepo->latestSales(10),

            /*
             * Products
             */
            'topProducts' => $salesRepo->topProducts(),

            /*
             * Inventory
             */
            'lowStock' => $inventoryRepo->lowStock(),
            'expiringSoon' => $inventoryRepo->expiringSoon(),

            /*
             * Global Counters
             */
            'customersCount' => $customersCount,
            'productsCount' => $productsCount,
            'usersCount' => $usersCount,

            /*
             * Chart Data
             */
            'dailySales' => $dailySales
        ]);
    }
}
