<?php

namespace App\Modules\Customers\Controllers;

use App\Core\Controller;

class CustomerController extends Controller
{
    public function index(): void
    {
        // Placeholder: fetch customers from service/repository
        $customers = []; // TODO: implement data fetching
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
