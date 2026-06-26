<?php

namespace App\Modules\Customers\Controllers;

use App\Core\Controller;

class CustomerController extends Controller
{
    public function index(): void
    {
        $db =
        \App\Core\Database::connect();

        $statement =
        $db->query(
            "
            SELECT *
            FROM customers
            ORDER BY id DESC
            "
        );

        $customers =
        $statement->fetchAll();

        $this->view(
            'customers.index',
            compact('customers')
        );
    }

    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $db = \App\Core\Database::connect();

        $stmt = $db->prepare(
            "
            SELECT *
            FROM customers
            WHERE id = ?
            LIMIT 1
            "
        );

        $stmt->execute([$id]);

        $customer =
            $stmt->fetch();

        if (!$customer) {

            die('Customer not found');
        }

        $salesStmt = $db->prepare(
            "
            SELECT *
            FROM sales
            WHERE customer_id = ?
            ORDER BY created_at DESC
            "
        );

        $salesStmt->execute([$id]);

        $sales =
            $salesStmt->fetchAll();

        $statsStmt = $db->prepare(
            "
            SELECT
                COUNT(*) total_sales,
                SUM(total) total_spent
            FROM sales
            WHERE customer_id = ?
            "
        );

        $statsStmt->execute([$id]);

        $stats =
            $statsStmt->fetch();

        $this->view(
            'customers.show',
            compact(
                'customer',
                'sales',
                'stats'
            )
        );
    }
}