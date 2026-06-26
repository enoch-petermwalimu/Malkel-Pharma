<?php

namespace App\Middleware;

/**
 * Auth middleware
 */
class AuthMiddleware
{
    public function handle(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }
}