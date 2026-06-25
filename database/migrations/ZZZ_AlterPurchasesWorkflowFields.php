<?php

use App\Core\Migration;

/**
 * Purchase workflow upgrade
 */
class AlterPurchasesWorkflowFields extends Migration
{
    public function up(): void
    {
        $this->db->exec("
            ALTER TABLE purchases
            ADD COLUMN order_status VARCHAR(50)
                DEFAULT 'draft',

            ADD COLUMN supplier_invoice_number
                VARCHAR(100) NULL,

            ADD COLUMN due_date DATE NULL
        ");
    }

    public function down(): void
    {
        //
    }
}