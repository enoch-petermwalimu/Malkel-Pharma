<?php

namespace App\Core;

/**
 * Application kernel
 */
class Application
{
    protected Router $router;

    public function __construct()
    {
        $this->router =
            new Router();
    }

    public function router(): Router
    {
        return $this->router;
    }

    public function run(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $request = new Request();

        $this->router->resolve($request);
    }
}