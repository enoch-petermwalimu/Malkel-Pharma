<?php

if (!function_exists('response_success')) {

    function response_success(
        string $message,
        array $data = []
    ): array {

        return [
            'success' => true,
            'message' => $message,
            'data' => $data
        ];
    }
}

if (!function_exists('response_error')) {

    function response_error(
        string $message,
        array $errors = []
    ): array {

        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ];
    }
}