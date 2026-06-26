<?php

use App\Core\Migration;

class AlterInventoryBatchesAddCheckConstraint extends Migration
{
    public function up(): void
    {
        // Add CHECK constraint to prevent negative stock
        $this->db->exec("
            ALTER TABLE inventory_batches
            ADD CONSTRAINT chk_quantity_non_negative
            CHECK (quantity >= 0)
        ");
    }

    public function down(): void
    {
        $this->db->exec("
            ALTER TABLE inventory_batches
            DROP CONSTRAINT chk_quantity_non_negative
        ");
    }
}
