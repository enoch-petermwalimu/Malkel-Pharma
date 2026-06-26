<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/app/Helpers/helpers.php';

use App\Core\Application;
use App\Core\View;

use App\Modules\Auth\Controllers\AuthController;
use App\Modules\Products\Controllers\ProductController;
use App\Modules\Inventory\Controllers\InventoryController;
use App\Modules\POS\Controllers\POSController;
use App\Modules\Sales\Controllers\SaleController;
use App\Modules\Sales\Controllers\SalesHistoryController;
use App\Modules\Customers\Controllers\CustomerController;
use App\Modules\Dashboard\Controllers\DashboardController;
use App\Modules\Suppliers\Controllers\SupplierController;
use App\Modules\Purchases\Controllers\PurchaseController;
use App\Modules\Returns\Controllers\ReturnController;
use App\Modules\Settings\Controllers\SettingsController;
use App\Modules\Reports\Controllers\ReportController;
use App\Modules\System\Controllers\SystemController;
/**
 * Session
 */
session_start();

/**
 * App
 */
$app = new Application();
$router = $app->router();

/**
 * Home
 */
$router->get('/', function () {
    View::render('home');
});

/**
 * Auth
 */
$router->get('/login', [
    AuthController::class,
    'loginView'
]);

$router->post('/login', [
    AuthController::class,
    'login'
]);

$router->get('/register', [
    AuthController::class,
    'registerView'
]);

$router->post('/register', [
    AuthController::class,
    'register'
]);

$router->get('/logout', [
    AuthController::class,
    'logout'
]);

/**
 * Products
 */
$router->get('/products', [
    ProductController::class,
    'index'
]);

$router->get('/products/create', [
    ProductController::class,
    'create'
]);
$router->get('/products/edit', [
    ProductController::class,
    'edit'
]);

$router->post('/products/update', [
    ProductController::class,
    'update'
]);

$router->post('/products', [
    ProductController::class,
    'store'
]);

$router->get('/products/search', [
    ProductController::class,
    'search'
]);

$router->get('/products/barcode', [
    ProductController::class,
    'barcode'
]);

/**
 * Inventory
 */
$router->get('/inventory', [
    InventoryController::class,
    'index'
]);

$router->get('/inventory/batches/create', [
    InventoryController::class,
    'createBatchView'
]);

$router->post('/inventory/batches', [
    InventoryController::class,
    'storeBatch'
]);

$router->post('/inventory/adjust', [
    InventoryController::class,
    'adjust'
]);

$router->post('/inventory/expired', [
    InventoryController::class,
    'expired'
]);

$router->post('/inventory/damaged', [
    InventoryController::class,
    'damaged'
]);

$router->get('/inventory/edit', [
    InventoryController::class,
    'edit'
]);

$router->post('/inventory/update', [
    InventoryController::class,
    'update'
]);


/**
 * POS
 */
$router->get('/pos', [
    POSController::class,
    'index'
]);
$router->get('/products/search', [
    ProductController::class,
    'search'
]);

/**
 * Sales
 */
$router->post('/sales/checkout', [
    SaleController::class,
    'checkout'
]);

$router->get('/sales/history', [
    SalesHistoryController::class,
    'index'
]);

$router->get('/sales/show', [
    SalesHistoryController::class,
    'show'
]);

$router->get('/sales/pdf', [
    \App\Modules\Sales\Controllers\InvoiceController::class,
    'pdf'
]);

$router->get('/sales/receipt', [
    \App\Modules\Sales\Controllers\ReceiptController::class,
    'show'
]);

/**
 * Customers
 */
$router->get('/customers/search', [
    CustomerController::class,
    'search'
]);

/**
 * Dashboard
 */
$router->get('/dashboard', [
    DashboardController::class,
    'index'
]);

/**
 * Suppliers
 */
$router->get('/suppliers', [
    SupplierController::class,
    'index'
]);

$router->post('/suppliers/store', [
    SupplierController::class,
    'store'
]);

$router->get('/suppliers/search', [
    SupplierController::class,
    'search'
]);

$router->post('/suppliers/update', [
    SupplierController::class,
    'update'
]);
$router->post('/suppliers/delete', [
    SupplierController::class,
    'delete'
]);

/**
 * Purchases
 */
$router->get('/purchases', [
    PurchaseController::class,
    'index'
]);

$router->post('/purchases/store', [
    PurchaseController::class,
    'store'
]);

$router->get('/purchases/history', [
    PurchaseController::class,
    'history'
]);

/**
 * Returns
 */
$router->post('/returns/customer', [
    ReturnController::class,
    'customer'
]);

$router->post('/returns/supplier', [
    ReturnController::class,
    'supplier'
]);

$router->get('/returns', function () {
    include dirname(__DIR__) . '/resources/views/returns/index.php';
});

$router->post('/products/store', [
    ProductController::class,
    'store'
]);
/*
|--------------------------------------------------------------------------
| CUSTOMERS
|--------------------------------------------------------------------------
*/

$router->get('/customers', [
    CustomerController::class,
    'index'
]);

$router->get('/customers/create', [
    CustomerController::class,
    'create'
]);

$router->post('/customers/store', [
    CustomerController::class,
    'store'
]);

$router->get('/customers/show', [
    CustomerController::class,
    'show'
]);

/*
|--------------------------------------------------------------------------
| SETTINGS
|--------------------------------------------------------------------------
*/

$router->get('/settings', [
    SettingsController::class,
    'index'
]);

$router->post('/settings/update', [
    SettingsController::class,
    'update'
]);

/*
|--------------------------------------------------------------------------
| REPORTS
|--------------------------------------------------------------------------
*/

$router->get('/reports', [
    ReportController::class,
    'index'
]);

$router->get('/reports/sales', [
    ReportController::class,
    'sales'
]);

$router->get('/reports/products', [
    ReportController::class,
    'products'
]);

$router->get('/reports/customers', [
    ReportController::class,
    'customers'
]);

$router->get('/sales-test', [
    SalesHistoryController::class,
    'index'
]);

/**SYSTEM ROUTES */

$router->get(
    '/system',
    [
        SystemController::class,
        'index'
    ]
);


/**
 * Run
 */
$app->run();