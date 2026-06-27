<?php

namespace App\Modules\Reports\Controllers;

use App\Core\Controller;

class ReportController extends Controller
{
    public function index(): void
    {
        echo '<h1>Reports</h1>';
    }

    public function sales(): void
    {
        echo '<h1>Sales Report</h1>';
    }

    public function products(): void
    {
        echo '<h1>Products Report</h1>';
    }

    public function customers(): void
    {
        echo '<h1>Customers Report</h1>';
    }
}