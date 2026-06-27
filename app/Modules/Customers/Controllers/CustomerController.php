<?php

namespace App\Modules\Customers\Controllers;

use App\Core\Controller;
use App\Modules\Customers\Services\CustomerService;

class CustomerController extends Controller
{
    protected CustomerService $service;

    public function __construct()
    {
        $this->service = new CustomerService();
    }

    public function index(): void
    {
        $customers = $this->service->getAll();
        $this->view('customers.index', ['customers' => $customers]);
    }

    public function create(): void
    {
        // Placeholder
        $this->json(['message' => 'Customer create view under construction']);
    }

    public function store(): void
    {
        // Placeholder
        $this->json(['message' => 'Customer store action under construction']);
    }

    public function show(): void
    {
        // Placeholder
        $this->json(['message' => 'Customer show view under construction']);
    }

    public function search(): void
    {
        // Placeholder
        $this->json(['message' => 'Customer search under construction']);
    }
}
