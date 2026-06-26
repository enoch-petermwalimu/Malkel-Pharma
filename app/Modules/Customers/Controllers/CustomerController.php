<?php

namespace App\Modules\Customers\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Modules\Customers\Services\CustomerService;

/**
 * Customer Controller
 */
class CustomerController extends Controller
{
    protected CustomerService $service;

    public function __construct()
    {
        $this->service = new CustomerService();
    }

    /**
     * Customer list
     */
    public function index(): void
    {
        $customers = $this->service->all();

        $this->view('customers.index', [
            'customers' => $customers
        ]);
    }

    /**
     * Search customers (JSON)
     */
    public function search(): void
    {
        $term = trim($_GET['q'] ?? '');

        if ($term === '') {
            $this->json([
                'success' => true,
                'customers' => []
            ]);
            return;
        }

        $customers = $this->service->search($term);

        $this->json([
            'success' => true,
            'customers' => $customers
        ]);
    }

    /**
     * Store customer
     */
    public function store(): void
    {
        $request = new Request();

        $data = $request->body();

        $created = $this->service->create([
            'full_name' => $data['full_name'] ?? '',
            'phone' => $data['phone'] ?? '',
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null
        ]);

        if ($created) {
            $this->json([
                'success' => true,
                'customer_id' => (int) $this->service->lastInsertId()
            ]);
        } else {
            $this->json([
                'success' => false,
                'message' => 'Failed to create customer'
            ], 500);
        }
    }
}
