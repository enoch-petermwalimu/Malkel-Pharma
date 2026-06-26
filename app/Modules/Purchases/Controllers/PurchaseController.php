<?php

namespace App\Modules\Purchases\Controllers;

use App\Core\Controller;
use App\Core\Request;

use App\Modules\Purchases\Services\PurchaseService;

/**
 * Purchase Controller
 */
class PurchaseController extends Controller
{
    protected PurchaseService $service;

    public function __construct()
    {
        $this->service = new PurchaseService();
    }

    /**
     * View
     */
    public function index(): void
    {
        $purchases = $this->service->history();

        $this->view('purchases.index', [
            'purchases' => $purchases
        ]);
    }

    /**
     * Create form
     */
    public function create(): void
    {
        $this->view('purchases.create');
    }

    /**
     * Store purchase
     */
    public function store(): void
    {
        $request = new Request();

        $data = $request->body();

        $success =
            $this->service->create($data);

        $this->json([
            'success' => $success
        ]);
    }

    /**
     * History
     */
    public function history(): void
    {
        $purchases = $this->service->history();

        $this->view('purchases.index', [
            'purchases' => $purchases
        ]);
    }
}
