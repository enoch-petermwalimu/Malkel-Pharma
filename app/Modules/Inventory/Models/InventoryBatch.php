<?php

namespace App\Modules\Inventory\Models;

use App\Core\Model;

/**
 * ----------------------------------------------------------------
 * Inventory Batch Model
 * ----------------------------------------------------------------
 * Gestion lots produits.
 * ----------------------------------------------------------------
 */

class InventoryBatch extends Model
{
    /**
     * Table SQL
     */
    protected string $table = 'inventory_batches';
}