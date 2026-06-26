<?php

namespace App\Middleware;

/**
 * Role middleware
 */
class RoleMiddleware
{
    public function handle(
        string $requiredRole
    ): void {
        if (
            !isset($_SESSION['user'])
            || $_SESSION['user']['role']
                !== $requiredRole
        ) {
            http_response_code(403);
            exit('Forbidden');
        }
    }
}