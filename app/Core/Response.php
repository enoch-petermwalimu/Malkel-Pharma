<?php

namespace App\Core;

/**
 * HTTP Response
 */
class Response
{
    /**
     * JSON response
     */
    public static function json(
        array $data,
        int $status = 200
    ): void {
        http_response_code($status);

        header('Content-Type: application/json');

        echo json_encode($data);

        exit;
    }

    /**
     * Redirect
     */
    public static function redirect(
        string $url
    ): void {
        header("Location: {$url}");
        exit;
    }
}