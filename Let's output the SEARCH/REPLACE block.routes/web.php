<?php

$router->get('/reports', [\App\Modules\Reports\Controllers\ReportController::class, 'index']);
$router->get('/reports/sales', [\App\Modules\Reports\Controllers\ReportController::class, 'sales']);
$router->get('/reports/products', [\App\Modules\Reports\Controllers\ReportController::class, 'products']);
$router->get('/reports/customers', [\App\Modules\Reports\Controllers\ReportController::class, 'customers']);
<?php

$router->get('/reports', [\App\Modules\Reports\Controllers\ReportController::class, 'index']);
$router->get('/reports/sales', [\App\Modules\Reports\Controllers\ReportController::class, 'sales']);
$router->get('/reports/products', [\App\Modules\Reports\Controllers\ReportController::class, 'products']);
$router->get('/reports/customers', [\App\Modules\Reports\Controllers\ReportController::class, 'customers']);
