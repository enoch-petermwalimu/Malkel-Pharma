<?php

namespace App\Modules\Returns\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Modules\Returns\Services\ReturnService;

/**
 * Returns controller
 */
class ReturnController extends Controller
{
    protected ReturnService $service;

    public function __construct()
    {
        $this->service = new ReturnService();
    }

    /**
     * Returns list
     */
    public function index(): void
    {
        $returns = $this->service->all();

        $this->view('returns.index', [
            'returns' => $returns
        ]);
    }

    /**
     * Create return form
     */
    public function create(): void
    {
        $this->view('returns.create');
    }

    /**
     * Store return
     */
    public function store(): void
    {
        $request = new Request();

        $data = $request->body();

        $result = $this->service->create($data);

        if (!$result) {
            $this->json([
                'success' => false,
                'message' => 'Return creation failed'
            ], 500);
            return;
        }

        $this->json([
            'success' => true,
            'return_id' => $result['return_id'],
            'return_number' => $result['return_number']
        ]);
    }

    /**
     * Show return detail
     */
    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            $this->redirect('/returns');
            return;
        }

        $return = $this->service->find($id);

        if (!$return) {
            $this->redirect('/returns');
            return;
        }

        $items = $this->service->items($id);

        $this->view('returns.show', [
            'return' => $return,
            'items' => $items
        ]);
    }

    public function customer(): void
    {
        $request = new Request();

        $success =
            $this->service->customerReturn(
                $request->body()
            );

        $this->json([
            'success' => $success
        ]);
    }

    /**
     * Supplier return view
     */
    public function supplierView(): void
    {
        $this->view('returns.supplier');
    }

    public function supplier(): void
    {
        $request = new Request();

        $success =
            $this->service->supplierReturn(
                $request->body()
            );

        $this->json([
            'success' => $success
        ]);
    }
}
