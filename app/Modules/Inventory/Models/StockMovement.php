<?php

namespace App\Modules\Inventory\Models;

use App\Core\Model;

/**
 * ----------------------------------------------------------------
 * Stock Movement Model
 * ----------------------------------------------------------------
 * Historique mouvements stock.
 * ----------------------------------------------------------------
 */

class StockMovement extends Model
{
    /**
     * Table SQL
     */
    protected string $table = 'stock_movements';
}