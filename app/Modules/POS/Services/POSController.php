<?php

namespace App\Modules\POS\Controllers;

use App\Core\Controller;

/**
 * ----------------------------------------------------------------
 * POS Controller
 * ----------------------------------------------------------------
 * Interface caisse.
 * ----------------------------------------------------------------
 */

class POSController extends Controller
{
    /**
     * Interface POS
     */
    public function index(): void
    {
        $this->view('pos.index');
    }
}