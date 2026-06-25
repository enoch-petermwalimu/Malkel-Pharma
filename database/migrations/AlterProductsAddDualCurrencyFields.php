<?php

class AlterProductsAddDualCurrencyFields
{
    public function up(PDO $db)
    {
        $columns = $db->query("
            SHOW COLUMNS FROM products
        ")->fetchAll(PDO::FETCH_COLUMN);

        if (!in_array('purchase_price_usd', $columns)) {

            $db->exec("
                ALTER TABLE products
                ADD purchase_price_usd DECIMAL(12,2) DEFAULT 0.00,
                ADD purchase_price_cdf DECIMAL(12,2) DEFAULT 0.00,
                ADD selling_price_usd DECIMAL(12,2) DEFAULT 0.00,
                ADD selling_price_cdf DECIMAL(12,2) DEFAULT 0.00
            ");
        }
    }

    public function down(PDO $db)
    {
        // optionnel
    }
}