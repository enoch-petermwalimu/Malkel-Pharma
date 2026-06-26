<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Response;

class AdminMiddleware
{
    public function handle(): void
    {
        $user = Auth::user();

        if (!$user || $user['role'] !== 'admin') {

            Response::setStatusCode(403);

            echo "403 Forbidden";

            exit;
        }
    }
}