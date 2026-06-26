<?php

use App\Modules\Settings\Controllers\SettingsController;
use App\Modules\Products\Controllers\ProductController;

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
