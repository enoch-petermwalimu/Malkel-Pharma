<?php

namespace App\Core;

/**
 * HTTP Request
 */
class Request
{
    /**
     * Request method
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * Request path
     */
    public function path(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        $path = parse_url($path, PHP_URL_PATH);

        return rtrim($path, '/') ?: '/';
    }

    /**
     * Request body
     */
    public function body(): array
    {
        $method = $this->method();

        if ($method === 'GET') {
            return $_GET;
        }

        $contentType =
            $_SERVER['CONTENT_TYPE'] ?? '';

        /**
         * JSON payload
         */
        if (str_contains($contentType, 'application/json')) {

            $input =
                file_get_contents('php://input');

            $decoded =
                json_decode($input, true);

            return is_array($decoded)
                ? $decoded
                : [];
        }

        /**
         * Form payload
         */
        return $_POST;
    }
}