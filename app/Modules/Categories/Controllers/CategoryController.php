<?php

namespace App\Modules\Categories\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Modules\Categories\Services\CategoryService;

class CategoryController extends Controller
{
    protected CategoryService $service;

    public function __construct()
    {
        $this->service = new CategoryService();
    }

    public function index(): void
    {
        $categories = $this->service->all();

        $this->view('categories.index', [
            'categories' => $categories
        ]);
    }

    public function store(): void
    {
        $request = new Request();

        $this->service->create(
            $request->body()
        );

        $this->redirect('/categories');
    }
}