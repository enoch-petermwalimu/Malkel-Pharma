<?php

namespace App\Modules\Reports\Controllers;

use App\Core\Controller;
use App\Modules\Reports\Services\ReportService;

class ReportController extends Controller
{
    private ReportService $reportService;

    public function __construct()
    {
        $this->reportService = new ReportService();
    }

    public function index(): void
    {
        $activities = $this->reportService->getAllActivities();
        $this->view('reports.index', [
            'pageTitle' => 'Reports',
            'activities' => $activities,
        ]);
    }

    public function exportPdf(): void
    {
        $pdfContent = $this->reportService->generatePdf();

        // Set headers to output PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="report.pdf"');
        header('Content-Length: ' . strlen($pdfContent));
        echo $pdfContent;
        exit;
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
