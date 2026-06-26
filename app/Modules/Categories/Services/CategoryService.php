<?php

namespace App\Modules\Categories\Services;

use App\Modules\Categories\Models\Category;

class CategoryService
{
    protected Category $category;

    public function __construct()
    {
        $this->category = new Category();
    }

    public function all(): array
    {
        return $this->category->all();
    }

    public function create(array $data): bool
    {
        return $this->category->create([
            'name' => $data['name'] ?? '',
            'description' => $data['description'] ?? null
        ]);
    }
}