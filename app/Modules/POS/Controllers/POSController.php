<?php

namespace App\Modules\POS\Controllers;

use App\Core\Controller;

/**
 * POS Controller
 */
class POSController extends Controller
{
    /**
     * POS screen
     */
    public function index(): void
    {
        $this->view('pos.index');
    }
}