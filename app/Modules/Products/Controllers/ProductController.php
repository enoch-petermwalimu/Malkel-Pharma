<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Core\Request;

use App\Modules\Products\Services\ProductsService;

use App\Modules\Categories\Models\Category;

class ProductController extends Controller
{
    protected ProductsService $service;

    public function __construct()
    {
        $this->service = new ProductsService();
    }

    /**
     * Products list
     */
    public function index(): void
    {
        $products = $this->service->all();

        $this->view('products.index', [
            'products' => $products
        ]);
    }

    /**
     * Create form
     */
    public function create(): void
    {
        $db = \App\Core\Database::connect();

        $categories = $db->query("
            SELECT *
            FROM categories
            ORDER BY name ASC
        ")->fetchAll();

        $dosageForms = $db->query("
            SELECT *
            FROM dosage_forms
            ORDER BY name ASC
        ")->fetchAll();

        $packagingUnits = $db->query("
            SELECT *
            FROM packaging_units
            ORDER BY name ASC
        ")->fetchAll();

        $this->view('products.create', [
            'categories' => $categories,
            'dosageForms' => $dosageForms,
            'packagingUnits' => $packagingUnits
        ]);
    }

    /**
     * Store product
     */
    public function store(): void
    {
        $request = new Request();

        $data = $request->body();

        $created = $this->service->create([
            'name' => $data['name'] ?? '',
            'barcode' => $data['barcode'] ?? null,
            'sku' => $data['sku'] ?? null,
            'strength' => $data['strength'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'dosage_form_id' => $data['dosage_form_id'] ?? null,
            'packaging_unit_id' => $data['packaging_unit_id'] ?? null,
            'purchase_price' => $data['purchase_price'] ?? 0,
            'selling_price' => $data['price'] ?? 0,
            'minimum_stock_level' => $data['minimum_stock_level'] ?? 0,
            'description' => $data['description'] ?? null,
            'prescription_required' => isset($data['prescription_required']) ? 1 : 0,
            'is_temperature_sensitive' => isset($data['is_temperature_sensitive']) ? 1 : 0,
            'storage_temperature' => $data['storage_temperature'] ?? null,
            'active_ingredient' => $data['active_ingredient'] ?? null,
            'manufacturer' => $data['manufacturer'] ?? null,
            'therapeutic_class' => $data['therapeutic_class'] ?? null,
            'product_type' => $data['product_type'] ?? 'generic',
        ]);

        if ($created) {
            // Get the last inserted product ID
            $productId = (int) $this->service->findLastInsertId();

            // Automatically create inventory batch if stock quantity was provided
            $stockQty = (int) ($data['stock_quantity'] ?? 0);
            if ($stockQty > 0 && $productId > 0) {
                $inventoryService = new \App\Modules\Inventory\Services\InventoryService();
                $inventoryService->receiveStock([
                    'product_id' => $productId,
                    'batch_number' => $data['batch_number'] ?? 'INIT-' . time(),
                    'expiry_date' => $data['expiry_date'] ?? date('Y-m-d', strtotime('+5 years')),
                    'quantity' => $stockQty,
                    'supplier' => null,
                    'purchase_price' => $data['purchase_price'] ?? 0,
                    'selling_price' => $data['price'] ?? 0,
                    'minimum_stock_level' => $data['minimum_stock_level'] ?? 5
                ]);
            }
        }

        $this->redirect('/products');
    }


    /**
 * Edit form
 */
public function edit(): void
{
    $id = $_GET['id'] ?? 0;

    $product = $this->service->find((int) $id);

    if (!$product) {
        $this->redirect('/products');
        return;
    }

    $db = \App\Core\Database::connect();

    $categories = $db->query("
        SELECT *
        FROM categories
        ORDER BY name ASC
    ")->fetchAll();

    $dosageForms = $db->query("
        SELECT *
        FROM dosage_forms
        ORDER BY name ASC
    ")->fetchAll();

    $packagingUnits = $db->query("
        SELECT *
        FROM packaging_units
        ORDER BY name ASC
    ")->fetchAll();


    $this->view('products.edit', [
        'product' => $product,
        'categories' => $categories,
        'dosageForms' => $dosageForms,
        'packagingUnits' => $packagingUnits
    ]);
}

/**
 * Update product
 */
public function update(): void
{
    $id = $_POST['id'] ?? 0;

    $this->service->update((int) $id, [
        'name' => $_POST['name'] ?? '',
        'barcode' => $_POST['barcode'] ?? '',
        'sku' => $_POST['sku'] ?? '',
        'strength' => $_POST['strength'] ?? '',
        'category_id' => $_POST['category_id'] ?? null,
        'dosage_form_id' => $_POST['dosage_form_id'] ?? null,
        'packaging_unit_id' => $_POST['packaging_unit_id'] ?? null,
        'purchase_price' => $_POST['purchase_price'] ?? 0,
        'selling_price' => $_POST['price'] ?? 0,
        'minimum_stock_level' => $_POST['minimum_stock_level'] ?? 0,
        'description' => $_POST['description'] ?? null,
        'prescription_required' => isset($_POST['prescription_required']) ? 1 : 0,
        'is_temperature_sensitive' => isset($_POST['is_temperature_sensitive']) ? 1 : 0,
        'storage_temperature' => $_POST['storage_temperature'] ?? null,
        'active_ingredient' => $_POST['active_ingredient'] ?? null,
        'manufacturer' => $_POST['manufacturer'] ?? null,
        'therapeutic_class' => $_POST['therapeutic_class'] ?? null,
        'product_type' => $_POST['product_type'] ?? 'generic',
    ]);

    $this->redirect('/products');
    
}


    public function search(): void
    {
        $term = trim($_GET['q'] ?? '');

        if ($term === '') {

            header('Content-Type: application/json');

            echo json_encode([
                'success' => true,
                'products' => []
            ]);

            exit;
        }

        $products = $this->service->search($term);

        header(
            'Content-Type: application/json'
        );

        echo json_encode([

            'success' => true,

            'products' => $products

        ]);

        exit;
    }
}
