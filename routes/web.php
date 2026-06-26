<?php

use App\Modules\Settings\Controllers\SettingsController;
use App\Modules\Products\Controllers\ProductController;
use App\Modules\Inventory\Controllers\InventoryController;
use App\Modules\Customers\Controllers\CustomerController;
use App\Modules\Sales\Controllers\SaleController;
use App\Modules\Purchases\Controllers\PurchaseController;
use App\Modules\Suppliers\Controllers\SupplierController;

// Settings routes
$settingsController = new SettingsController();

// Route: GET /settings
if ($_SERVER['REQUEST_URI'] === '/settings' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $settingsController->index();
    exit;
}

// Route: POST /settings/update
if ($_SERVER['REQUEST_URI'] === '/settings/update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $settingsController->update();
    exit;
}

// Product routes
$productController = new ProductController();

// Route: GET /products
if ($_SERVER['REQUEST_URI'] === '/products' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $productController->index();
    exit;
}

// Route: GET /products/create
if ($_SERVER['REQUEST_URI'] === '/products/create' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $productController->create();
    exit;
}

// Route: POST /products/store
if ($_SERVER['REQUEST_URI'] === '/products/store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $productController->store();
    exit;
}

// Route: GET /products/edit
if (str_starts_with($_SERVER['REQUEST_URI'], '/products/edit') && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $productController->edit();
    exit;
}

// Route: POST /products/update
if ($_SERVER['REQUEST_URI'] === '/products/update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $productController->update();
    exit;
}

// Route: GET /products/search
if ($_SERVER['REQUEST_URI'] === '/products/search' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $productController->search();
    exit;
}

// Inventory routes
$inventoryController = new InventoryController();

// Route: GET /inventory
if ($_SERVER['REQUEST_URI'] === '/inventory' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $inventoryController->index();
    exit;
}

// Route: GET /inventory/create-batch
if ($_SERVER['REQUEST_URI'] === '/inventory/create-batch' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $inventoryController->createBatchView();
    exit;
}

// Route: POST /inventory/store-batch
if ($_SERVER['REQUEST_URI'] === '/inventory/store-batch' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $inventoryController->storeBatch();
    exit;
}

// Route: POST /inventory/adjust
if ($_SERVER['REQUEST_URI'] === '/inventory/adjust' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $inventoryController->adjust();
    exit;
}

// Route: POST /inventory/expired
if ($_SERVER['REQUEST_URI'] === '/inventory/expired' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $inventoryController->expired();
    exit;
}

// Route: POST /inventory/damaged
if ($_SERVER['REQUEST_URI'] === '/inventory/damaged' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $inventoryController->damaged();
    exit;
}

// Route: POST /inventory/update
if ($_SERVER['REQUEST_URI'] === '/inventory/update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $inventoryController->update();
    exit;
}

// Customer routes
$customerController = new CustomerController();

// Route: GET /customers
if ($_SERVER['REQUEST_URI'] === '/customers' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $customerController->index();
    exit;
}

// Route: GET /customers/search
if ($_SERVER['REQUEST_URI'] === '/customers/search' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $customerController->search();
    exit;
}

// Route: POST /customers/store
if ($_SERVER['REQUEST_URI'] === '/customers/store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerController->store();
    exit;
}

// POS routes
$saleController = new SaleController();

// Route: GET /pos
if ($_SERVER['REQUEST_URI'] === '/pos' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $saleController->index();
    exit;
}

// Route: POST /pos/checkout
if ($_SERVER['REQUEST_URI'] === '/pos/checkout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $saleController->checkout();
    exit;
}

// Route: GET /pos/invoice-lookup
if ($_SERVER['REQUEST_URI'] === '/pos/invoice-lookup' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $saleController->invoiceLookup();
    exit;
}

// Purchase routes
$purchaseController = new PurchaseController();

// Route: GET /purchases
if ($_SERVER['REQUEST_URI'] === '/purchases' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $purchaseController->index();
    exit;
}

// Route: GET /purchases/create
if ($_SERVER['REQUEST_URI'] === '/purchases/create' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $purchaseController->create();
    exit;
}

// Route: POST /purchases/store
if ($_SERVER['REQUEST_URI'] === '/purchases/store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $purchaseController->store();
    exit;
}

// Route: GET /purchases/history
if ($_SERVER['REQUEST_URI'] === '/purchases/history' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $purchaseController->index();
    exit;
}

// Supplier routes
$supplierController = new SupplierController();

// Route: GET /suppliers
if ($_SERVER['REQUEST_URI'] === '/suppliers' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $supplierController->index();
    exit;
}

// Route: POST /suppliers/store
if ($_SERVER['REQUEST_URI'] === '/suppliers/store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplierController->store();
    exit;
}

// Route: GET /suppliers/search
if ($_SERVER['REQUEST_URI'] === '/suppliers/search' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $supplierController->search();
    exit;
}

// Route: POST /suppliers/update
if ($_SERVER['REQUEST_URI'] === '/suppliers/update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplierController->update();
    exit;
}

// Route: POST /suppliers/delete
if ($_SERVER['REQUEST_URI'] === '/suppliers/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplierController->delete();
    exit;
}
