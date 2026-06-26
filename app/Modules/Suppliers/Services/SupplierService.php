<?php

namespace App\Modules\Suppliers\Services;

use App\Modules\Suppliers\Models\Supplier;
use App\Modules\Suppliers\Repositories\SupplierRepository;

/**
 * Supplier Service
 */
class SupplierService
{
    protected Supplier $model;
    protected SupplierRepository $repository;

    public function __construct()
    {
        $this->model = new Supplier();
        $this->repository = new SupplierRepository();
    }

    public function create(array $data): bool
    {
        return $this->model->create($data);
    }

    public function search(string $query): array
    {
        return $this->repository->search($query);
    }

    public function all(): array
    {
        return $this->repository->all();
    }

    public function update(
        int $id,
        array $data
    ): bool {

        return $this->repository
            ->update(
                $id,
                $data
            );
    }

    public function delete(
        int $id
    ): bool {

        return $this->model
            ->delete($id);
    }
}