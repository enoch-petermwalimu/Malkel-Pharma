<?php

namespace App\Modules\Customers\Services;

use App\Modules\Customers\Models\Customer;
use App\Modules\Customers\Repositories\CustomerRepository;

/**
 * -------------------------------------------------------------
 * Customer Service
 * -------------------------------------------------------------
 */
class CustomerService
{
    protected Customer $model;
    protected CustomerRepository $repository;

    public function __construct()
    {
        $this->model = new Customer();
        $this->repository = new CustomerRepository();
    }

    public function search(string $query): array
    {
        return $this->repository->search($query);
    }

    public function getAll(): array
    {
        return $this->repository->all();
    }

    public function create(array $data): bool
    {
        return $this->model->create($data);
    }
}
