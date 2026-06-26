<?php

namespace App\Modules\System\Services;

/**
 * ============================================================
 * System Service
 * ============================================================
 * Gestion des informations système :
 * - Version
 * - Build
 * - Statut
 * ============================================================
 */
class SystemService
{
    /**
     * Lire les informations
     * depuis version.json
     */
    public function version(): array
    {
        $file =
            dirname(__DIR__, 4)
            . '/version.json';

        if (!file_exists($file)) {

            return [

                'version' =>
                    'unknown',

                'build' =>
                    'unknown',

                'status' =>
                    'unknown'
            ];
        }

        return json_decode(

            file_get_contents(
                $file
            ),

            true
        );
    }
}