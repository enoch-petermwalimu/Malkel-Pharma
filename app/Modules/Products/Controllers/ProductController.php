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

        $this->service->create([
            'name' => $data['name'] ?? '',
            'barcode' => $data['barcode'] ?? null,
            'strength' => $data['strength'] ?? null,

            'price' => $data['price'] ?? 0,
            'purchase_price' => $data['purchase_price'] ?? 0,

            'stock_quantity' => $data['stock_quantity'] ?? 0,

            'minimum_stock_level' =>
                $data['minimum_stock_level'] ?? 0,

            'category_id' =>
                $data['category_id'] ?? null,

            'dosage_form_id' =>
                $data['dosage_form_id'] ?? null,

            'packaging_unit_id' =>
                $data['packaging_unit_id'] ?? null,

            'prescription_required' =>
                isset($data['prescription_required']) ? 1 : 0,

            'is_temperature_sensitive' =>
                isset($data['is_temperature_sensitive']) ? 1 : 0
        ]);

        $this->redirect('/products');
    }


    /**
 * Edit form
 */
public function edit(): void
{
    $id = $_GET['id'] ?? 0;

    $db = \App\Core\Database::connect();

    $stmt = $db->prepare("
        SELECT *
        FROM products
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    $product = $stmt->fetch();

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

    $db = \App\Core\Database::connect();

    $stmt = $db->prepare("
        UPDATE products
        SET
            name = ?,
            barcode = ?,
            strength = ?,
            selling_price = ?,
            purchase_price = ?,
            minimum_stock_level = ?,
            category_id = ?,
            dosage_form_id = ?,
            packaging_unit_id = ?,
            prescription_required = ?,
            is_temperature_sensitive = ?
        WHERE id = ?
    ");

    $stmt->execute([

        $_POST['name'] ?? '',

        $_POST['barcode'] ?? '',

        $_POST['strength'] ?? '',

        $_POST['price'] ?? 0,

        $_POST['purchase_price'] ?? 0,

        $_POST['minimum_stock_level'] ?? 0,

        $_POST['category_id'] ?? null,

        $_POST['dosage_form_id'] ?? null,

        $_POST['packaging_unit_id'] ?? null,

        isset($_POST['prescription_required'])
            ? 1
            : 0,

        isset($_POST['is_temperature_sensitive'])
            ? 1
            : 0,

        $id
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

        $db = \App\Core\Database::connect();

        $stmt = $db->prepare("
            SELECT
                p.id,
                p.name,
                p.strength,
                p.selling_price,

                COALESCE(
                    SUM(b.quantity),
                    0
                ) AS stock

            FROM products p

            LEFT JOIN inventory_batches b
                ON b.product_id = p.id

            WHERE
                p.name LIKE ?
                OR p.barcode LIKE ?

            GROUP BY
                p.id,
                p.name,
                p.strength,
                p.selling_price

            ORDER BY p.name ASC

            LIMIT 20
        ");

        $stmt->execute([
            '%' . $term . '%',
            '%' . $term . '%'
        ]);

        $products =
            $stmt->fetchAll(
                \PDO::FETCH_ASSOC
            );

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