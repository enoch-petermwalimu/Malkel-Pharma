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

    public function find(int $id): array|false
    {
        return $this->product->find($id);
    }

    public function create(array $data): bool
    {
        return $this->product->create([
            'name' => $data['name'] ?? '',
            'sku' => $data['sku'] ?? null,
            'barcode' => $data['barcode'] ?? null,
            'category' => $data['category'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'dosage_form_id' => $data['dosage_form_id'] ?? null,
            'packaging_unit_id' => $data['packaging_unit_id'] ?? null,
            'strength' => $data['strength'] ?? null,
            'description' => $data['description'] ?? null,
            'cost_price' => $data['cost_price'] ?? 0,
            'purchase_price' => $data['purchase_price'] ?? 0,
            'selling_price' => $data['selling_price'] ?? 0,
            'minimum_stock' => $data['minimum_stock'] ?? 0,
            'minimum_stock_level' => $data['minimum_stock_level'] ?? 0,
            'therapeutic_class' => $data['therapeutic_class'] ?? null,
            'active_ingredient' => $data['active_ingredient'] ?? null,
            'manufacturer' => $data['manufacturer'] ?? null,
            'requires_prescription' => isset($data['requires_prescription']) ? 1 : 0,
            'prescription_required' => isset($data['prescription_required']) ? 1 : 0,
            'is_temperature_sensitive' => isset($data['is_temperature_sensitive']) ? 1 : 0,
            'storage_temperature' => $data['storage_temperature'] ?? null,
            'is_controlled_substance' => isset($data['is_controlled_substance']) ? 1 : 0,
            'product_photo' => $data['product_photo'] ?? null,
            'product_type' => $data['product_type'] ?? 'generic',
        ]);
    }

    public function update(int $id, array $data): bool
    {
        return $this->product->update($id, [
            'name' => $data['name'] ?? '',
            'sku' => $data['sku'] ?? null,
            'barcode' => $data['barcode'] ?? null,
            'category' => $data['category'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'dosage_form_id' => $data['dosage_form_id'] ?? null,
            'packaging_unit_id' => $data['packaging_unit_id'] ?? null,
            'strength' => $data['strength'] ?? null,
            'description' => $data['description'] ?? null,
            'cost_price' => $data['cost_price'] ?? 0,
            'purchase_price' => $data['purchase_price'] ?? 0,
            'selling_price' => $data['selling_price'] ?? 0,
            'minimum_stock' => $data['minimum_stock'] ?? 0,
            'minimum_stock_level' => $data['minimum_stock_level'] ?? 0,
            'therapeutic_class' => $data['therapeutic_class'] ?? null,
            'active_ingredient' => $data['active_ingredient'] ?? null,
            'manufacturer' => $data['manufacturer'] ?? null,
            'requires_prescription' => isset($data['requires_prescription']) ? 1 : 0,
            'prescription_required' => isset($data['prescription_required']) ? 1 : 0,
            'is_temperature_sensitive' => isset($data['is_temperature_sensitive']) ? 1 : 0,
            'storage_temperature' => $data['storage_temperature'] ?? null,
            'is_controlled_substance' => isset($data['is_controlled_substance']) ? 1 : 0,
            'product_photo' => $data['product_photo'] ?? null,
            'product_type' => $data['product_type'] ?? 'generic',
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

    /**
     * Get last inserted product ID
     */
    public function findLastInsertId(): string|false
    {
        return $this->product->lastInsertId();
    }
}
