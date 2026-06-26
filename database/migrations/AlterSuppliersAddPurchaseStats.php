<?php

use App\Core\Migration;

class AlterSuppliersAddPurchaseStats extends Migration
{
    public function up(): void
    {
        $columns = [];
        $result = $this->db->query("SHOW COLUMNS FROM suppliers");
        foreach ($result->fetchAll() as $column) {
            $columns[] = $column['Field'];
        }

        if (!in_array('total_purchases', $columns)) {
            $this->db->exec("
                ALTER TABLE suppliers
                ADD COLUMN total_purchases INT DEFAULT 0,
                ADD COLUMN last_purchase_date DATETIME NULL
            ");
        }
    }

    public function down(): void
    {
        // No rollback needed
    }
}
