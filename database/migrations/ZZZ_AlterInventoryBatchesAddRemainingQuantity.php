<?php

class AlterInventoryBatchesAddRemainingQuantity
{
    public function up(PDO $db)
    {
        $exists = $db->query("
            SHOW COLUMNS
            FROM inventory_batches
            LIKE 'remaining_quantity'
        ");

        if ($exists->rowCount() === 0) {

            $db->exec("
                ALTER TABLE inventory_batches
                ADD remaining_quantity INT
                DEFAULT 0
                AFTER quantity
            ");

            $db->exec("
                UPDATE inventory_batches
                SET remaining_quantity = quantity
            ");
        }
    }

    public function down(PDO $db)
    {
    }
}