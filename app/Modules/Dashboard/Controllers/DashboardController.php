<?php

namespace App\Modules\Dashboard\Controllers;

use App\Core\Controller;
use App\Modules\Sales\Repositories\SaleRepository;
use App\Modules\Inventory\Repositories\InventoryRepository;
use App\Modules\Customers\Repositories\CustomerRepository;
use App\Modules\Products\Repositories\ProductRepository;
use App\Modules\Users\Repositories\UserRepository;
use App\Core\Database;

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

            if (class_exists(CustomerRepository::class)) {

                $customerRepo =
                    new CustomerRepository();

                $customersCount =
                    count(
                        $customerRepo->all()
                    );
            }

            if (class_exists(ProductRepository::class)) {

                $productRepo =
                    new ProductRepository();

                $productsCount =
                    count(
                        $productRepo->all()
                    );
            }

            if (class_exists(UserRepository::class)) {

                $userRepo =
                    new UserRepository();

                $usersCount =
                    count(
                        $userRepo->all()
                    );
            }

        } catch (\Throwable $e) {

            // Ignore dashboard counters errors
        }

        $salesToday =
            count(
                $salesRepo->todaySales()
            );

        $this->view(
            'dashboard.index',
            [

                /*
                 * Revenue
                 */
                'todayRevenue' =>
                    $salesRepo->todayRevenue(),

                'totalRevenue' =>
                    $salesRepo->totalRevenue(),

                'revenue3Days' =>
                    $salesRepo->revenueLast3Days(),

                'revenue7Days' =>
                    $salesRepo->revenueLast7Days(),

                /*
                 * Sales
                 */
                'salesToday' =>
                    $salesToday,

                'totalSalesCount' =>
                    $salesRepo->totalSalesCount(),

                'latestSales' =>
                    $salesRepo->latestSales(10),

                /*
                 * Products
                 */
                'topProducts' =>
                    $salesRepo->topProducts(),

                /*
                 * Inventory
                 */
                'lowStock' =>
                    $inventoryRepo->lowStock(),

                'expiringSoon' =>
                    $inventoryRepo->expiringSoon(),

                /*
                 * Global Counters
                 */
                'customersCount' =>
                    $customersCount,

                'productsCount' =>
                    $productsCount,

                'usersCount' =>
                    $usersCount
            ]
        );

        $customersCount = 0;
        $productsCount = 0;
        $usersCount = 0;

        try {

            $db = Database::connect();

            $customersCount =
                (int) $db
                    ->query(
                        "SELECT COUNT(*) total
                        FROM customers"
                    )
                    ->fetch()['total'];

            $productsCount =
                (int) $db
                    ->query(
                        "SELECT COUNT(*) total
                        FROM products"
                    )
                    ->fetch()['total'];

            $usersCount =
                (int) $db
                    ->query(
                        "SELECT COUNT(*) total
                        FROM users"
                    )
                    ->fetch()['total'];

        } catch (\Throwable $e) {

            // Dashboard must continue working
        }
    }
}