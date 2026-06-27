<?php

use App\Core\Router;
use App\Modules\Reports\Controllers\ReportController;

$router = new Router();

$router->get('/reports', [ReportController::class, 'index']);
$router->get('/reports/export-pdf', [ReportController::class, 'exportPdf']);

// Resolve the current request
$router->resolve(new \App\Core\Request());
