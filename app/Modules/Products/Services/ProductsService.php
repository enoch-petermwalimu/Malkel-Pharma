<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Models\Product;

class ProductsService
{
    protected Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function all(): array
    {
        return $this->product->allWithStock();
    }

    public function create(array $data): bool
    {
        return $this->product->create([
            'name' => $data['name'] ?? '',
            'barcode' => $data['barcode'] ?? null,
            'sku' => $data['sku'] ?? null,
            'selling_price' => $data['selling_price'] ?? 0,
            'cost_price' => $data['cost_price'] ?? 0
        ]);
    }

    public function search(string $query): array
    {
        if (!$query) {
            return [];
        }

        return $this->product->search($query);
    }

    public function findByBarcode(string $barcode): ?array
    {
        return $this->product->findByBarcode($barcode);
    }
}