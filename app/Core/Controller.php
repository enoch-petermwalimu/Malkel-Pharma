<?php

namespace App\Core;

/**
 * Base controller
 */
class Controller
{
    /**
     * Render view
     */
    protected function view(
        string $view,
        array $data = []
    ): void {
        View::render($view, $data);
    }

    /**
     * JSON response
     */
    protected function json(
        array $data,
        int $status = 200
    ): void {
        Response::json($data, $status);
    }

    /**
     * Redirect
     */
    protected function redirect(
        string $url
    ): void {
        Response::redirect($url);
    }
}