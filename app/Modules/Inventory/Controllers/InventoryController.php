<?php

namespace App\Modules\Inventory\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Modules\Inventory\Repositories\InventoryRepository;
use App\Modules\Inventory\Services\InventoryService;

/**
 * ============================================================
 * Inventory Controller
 * ============================================================
 */
class InventoryController extends Controller
{
    protected InventoryRepository $repository;
    protected InventoryService $service;

    public function __construct()
    {
        $this->repository = new InventoryRepository();
        $this->service = new InventoryService();
    }

    /**
     * Inventory dashboard
     */
    public function index(): void
    {
        $batches = $this->repository->allBatches();

        $this->view('inventory.index', [
            'batches' => $batches
        ]);
    }

    /**
     * Physical adjustment
     */
    public function adjust(): void
    {
        $request = new Request();

        $data = $request->body();

        $success =
            $this->service->adjustPhysicalCount($data);

        $this->json([
            'success' => $success
        ]);
    }

    /**
     * Mark expired
     */
    public function expired(): void
    {
        $request = new Request();

        $data = $request->body();

        $success =
            $this->service->markExpired(
                (int) $data['batch_id'],
                (int) ($data['quantity'] ?? 0)
            );

        $this->json([
            'success' => $success
        ]);
    }

    /**
     * Mark damaged
     */
    public function damaged(): void
    {
        $request = new Request();

        $data = $request->body();

        $success =
            $this->service->markDamaged(
                (int) $data['batch_id'],
                (int) $data['quantity'],
                $data['reason']
            );

        $this->json([
            'success' => $success
        ]);
    }



    public function createBatchView(): void
    {
        $this->requirePharmacist();

        $this->view(
            'inventory.create-batch'
        );
    }

    public function storeBatch(): void
    {
        $request = new Request();

        $data = $request->body();

        $success =
            $this->service->receiveStock([
                'product_id'     => $data['product_id'],
                'batch_number'   => $data['batch_number'],
                'expiry_date'    => $data['expiry_date'],
                'quantity'       => $data['quantity'],
                'supplier'       => $data['supplier'] ?? null,
                'purchase_price' => $data['purchase_price'] ?? 0,
                'selling_price'  => $data['selling_price'] ?? 0
            ]);

        if ($success) {

            $this->redirect('/inventory');

            return;
        }

        exit('Erreur création lot');
    }    


        public function update(): void
        {
            $request = new Request();

            $data = $request->body();

            $batchId = (int) ($data['id'] ?? 0);

            if ($batchId <= 0) {
                $this->redirect('/inventory');
                return;
            }

            $batchModel =
                new \App\Modules\Inventory\Models\InventoryBatch();

            // Check if batch exists
            $existing = $batchModel->find($batchId);

            if (!$existing) {
                $this->redirect('/inventory');
                return;
            }

            $updated = $batchModel->update(
                $batchId,
                [
                    'batch_number' =>
                        $data['batch_number'] ?? $existing['batch_number'],

                    'expiry_date' =>
                        $data['expiry_date'] ?? $existing['expiry_date'],

                    'quantity' =>
                        $data['quantity'] ?? $existing['quantity'],

                    'supplier' =>
                        $data['supplier'] ?? $existing['supplier'],

                    'purchase_price' =>
                        $data['purchase_price'] ?? $existing['purchase_price'],

                    'selling_price' =>
                        $data['selling_price'] ?? $existing['selling_price']
                ]
            );

            if (!$updated) {
                // Log error or handle failure
            }

            // Create movement log for the update
            $this->service->createMovement([
                'product_id' => $existing['product_id'],
                'batch_id' => $batchId,
                'movement_type' => 'batch_update',
                'quantity' => 0,
                'notes' => 'Batch details updated'
            ]);

            $this->redirect('/inventory');
        }
}
