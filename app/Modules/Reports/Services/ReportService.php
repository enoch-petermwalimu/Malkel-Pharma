<?php

namespace App\Modules\Reports\Services;

use App\Modules\Sales\Models\Sale;
use App\Modules\Purchases\Models\Purchase;
use App\Modules\Inventory\Models\StockMovement;
use App\Modules\Returns\Models\ReturnModel;

class ReportService
{
    /**
     * Get all pharma activities data.
     *
     * @return array
     */
    public function getAllActivities(): array
    {
        $saleModel = new Sale();
        $purchaseModel = new Purchase();
        $stockMovementModel = new StockMovement();
        $returnModel = new ReturnModel();

        $sales = $saleModel->all();
        $purchases = $purchaseModel->all();
        $stockMovements = $stockMovementModel->all();
        $returns = $returnModel->all();

        return [
            'sales' => $sales,
            'purchases' => $purchases,
            'stockMovements' => $stockMovements,
            'returns' => $returns,
        ];
    }

    /**
     * Generate PDF report.
     *
     * @return string PDF content
     */
    public function generatePdf(): string
    {
        $data = $this->getAllActivities();

        // Create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('Malkel Pharma');
        $pdf->SetAuthor('Malkel Pharma');
        $pdf->SetTitle('Pharma Activities Report');
        $pdf->SetSubject('All Activities');

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Title
        $pdf->Cell(0, 10, 'Pharma Activities Report', 0, 1, 'C');
        $pdf->Ln(10);

        // Sales section
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Sales', 0, 1);
        $pdf->SetFont('helvetica', '', 10);
        foreach ($data['sales'] as $sale) {
            $pdf->Cell(0, 6, 'Sale #' . $sale->id . ' - Total: $' . number_format($sale->total, 2), 0, 1);
        }
        $pdf->Ln(5);

        // Purchases section
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Purchases', 0, 1);
        $pdf->SetFont('helvetica', '', 10);
        foreach ($data['purchases'] as $purchase) {
            $pdf->Cell(0, 6, 'Purchase #' . $purchase->id . ' - Total: $' . number_format($purchase->total, 2), 0, 1);
        }
        $pdf->Ln(5);

        // Stock Movements section
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Stock Movements', 0, 1);
        $pdf->SetFont('helvetica', '', 10);
        foreach ($data['stockMovements'] as $movement) {
            $pdf->Cell(0, 6, 'Movement #' . $movement->id . ' - Type: ' . $movement->type . ' - Qty: ' . $movement->quantity, 0, 1);
        }
        $pdf->Ln(5);

        // Returns section
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Returns', 0, 1);
        $pdf->SetFont('helvetica', '', 10);
        foreach ($data['returns'] as $return) {
            $pdf->Cell(0, 6, 'Return #' . $return->id . ' - Reason: ' . $return->reason, 0, 1);
        }

        // Output PDF as string
        return $pdf->Output('report.pdf', 'S');
    }
}
