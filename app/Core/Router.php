<?php

namespace App\Core;

/**
 * Simple Router
 */
class Router
{
    protected array $routes = [];

    public function get(
        string $path,
        $handler
    ): void {
        $this->routes['GET'][$path] =
            $handler;
    }

    public function post(
        string $path,
        $handler
    ): void {
        $this->routes['POST'][$path] =
            $handler;
    }

    public function resolve(
        Request $request
    ): void {
        $method =
            $request->method();

        $path =
            $request->path();

        $handler =
            $this->routes[$method][$path]
            ?? null;

        if (!$handler) {
            http_response_code(404);
            exit('404 Not Found');
        }

        /**
         * Closure
         */
        if (is_callable($handler)) {
            call_user_func($handler);
            return;
        }

        /**
         * Controller action
         */
        if (is_array($handler)) {

            [$class, $action] =
                $handler;

            $controller =
                new $class();

            $controller->$action();

            return;
        }

        http_response_code(500);
        exit('Invalid route handler');
    }
}