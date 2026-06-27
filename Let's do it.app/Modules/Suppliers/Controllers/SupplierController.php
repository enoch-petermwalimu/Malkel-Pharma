<?php

namespace App\Modules\Suppliers\Controllers;

use App\Core\Controller;
use App\Modules\Suppliers\Services\SupplierService;

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
     * List all suppliers
     */
    public function index(): void
    {
        $suppliers = $this->service->all();

        $this->view('suppliers.index', [
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Show create form
     */
    public function create(): void
    {
        $this->view('suppliers.create');
    }

    /**
     * Store new supplier
     */
    public function store(): void
    {
        $request = new \App\Core\Request();

        $data = $request->body();

        $success = $this->service->create($data);

        if ($success) {
            $this->redirect('/suppliers');
            return;
        }

        exit('Erreur création fournisseur');
    }

    /**
     * Show edit form
     */
    public function edit(int $id): void
    {
        $supplier = $this->service->find($id);

        if (!$supplier) {
            exit('Fournisseur introuvable');
        }

        $this->view('suppliers.edit', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Update supplier
     */
    public function update(int $id): void
    {
        $request = new \App\Core\Request();

        $data = $request->body();

        $success = $this->service->update($id, $data);

        if ($success) {
            $this->redirect('/suppliers');
            return;
        }

        exit('Erreur mise à jour fournisseur');
    }

    /**
     * Disable supplier
     */
    public function disable(int $id): void
    {
        $success = $this->service->disable($id);

        $this->json([
            'success' => $success
        ]);
    }

    /**
     * Search suppliers (JSON)
     */
    public function search(): void
    {
        $request = new \App\Core\Request();

        $query = $request->body()['query'] ?? '';

        $results = $this->service->search($query);

        $this->json([
            'results' => $results
        ]);
    }

    /**
     * Purchase history for a supplier
     */
    public function purchaseHistory(int $id): void
    {
        $purchases = $this->service->purchaseHistory($id);

        $this->view('suppliers.purchase-history', [
            'purchases' => $purchases
        ]);
    }
}
