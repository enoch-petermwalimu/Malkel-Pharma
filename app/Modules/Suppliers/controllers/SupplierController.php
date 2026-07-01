<?php

namespace App\Modules\Suppliers\Controllers;

use App\Core\Controller;
use App\Core\Request;

use App\Modules\Suppliers\Services\SupplierService;
use App\Modules\WhatsApp\Services\WhatsAppService;

/**
 * Supplier Controller
 */
class SupplierController extends Controller
{
    protected SupplierService $service;

    public function __construct()
    {
        $this->service = new SupplierService();
    }

    /**
     * List
     */
    public function index(): void
    {
        $suppliers = $this->service->all();

        $this->view('suppliers.index', [
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Create
     */
    public function store(): void
    {
        $request = new Request();

        $data = $request->body();

        $created =
            $this->service->create($data);

        $this->json([
            'success' => $created
        ]);
    }

    /**
     * Search API
     */
    public function search(): void
    {
        $query = $_GET['q'] ?? '';

        $suppliers =
            $this->service->search($query);

        $this->json([
            'success' => true,
            'suppliers' => $suppliers
        ]);
    }


    /**
     * Update supplier
     */
    public function update(): void
    {
        $id =
            (int) ($_POST['id'] ?? 0);

        $request =
            new Request();

        $success =
            $this->service->update(
                $id,
                $request->body()
            );

        $this->json([
            'success' => $success
        ]);
    }

/**
 * Delete supplier
 */
public function delete(): void
{
    $id =
        (int) ($_POST['id'] ?? 0);

    $success =
        $this->service->delete($id);

    $this->json([
        'success' => $success
    ]);
}

/**
 * Send PDF to client via WhatsApp
 */
public function sendPdfToClient(): void
{
    $request = new Request();
    $data = $request->body();

    $phone = $data['phone'] ?? '';
    $pdfUrl = $data['pdf_url'] ?? '';
    $caption = $data['caption'] ?? '';

    if (empty($phone) || empty($pdfUrl)) {
        $this->json([
            'success' => false,
            'message' => 'Phone and pdf_url are required'
        ]);
        return;
    }

    $whatsApp = new WhatsAppService();
    $result = $whatsApp->sendPdf($phone, $pdfUrl, $caption);

    $this->json($result);
}
}
