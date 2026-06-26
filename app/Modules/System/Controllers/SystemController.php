<?php

namespace App\Modules\System\Controllers;

use App\Core\Controller;
use App\Modules\System\Services\SystemService;

/**
 * ============================================================
 * System Controller
 * ============================================================
 * Affichage des informations système
 * ============================================================
 */
class SystemController extends Controller
{
    /**
     * System dashboard
     */
    public function index(): void
    {
        $service =
            new SystemService();

        $this->view(

            'system.index',

            [

                'version' =>
                    $service->version()
            ]
        );
    }
}