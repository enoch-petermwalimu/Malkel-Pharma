<?php

use App\Core\Router;
use App\Modules\Reports\Controllers\ReportController;
use App\Modules\Suppliers\Controllers\SupplierController;

$router = new Router();

$router->get('/reports', [ReportController::class, 'index']);
$router->get('/reports/export-pdf', [ReportController::class, 'exportPdf']);

$router->post('/suppliers/send-pdf', [SupplierController::class, 'sendPdfToClient']);

// Resolve the current request
$router->resolve(new \App\Core\Request());
