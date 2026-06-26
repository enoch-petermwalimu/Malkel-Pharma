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