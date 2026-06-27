<?php

if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        $base = dirname(__DIR__, 2);

        return $path ? $base . DIRECTORY_SEPARATOR . $path : $base;
    }
}

if (!function_exists('storage_path')) {
    function storage_path(string $path = ''): string
    {
        $base = base_path('storage');

        return $path ? $base . DIRECTORY_SEPARATOR . $path : $base;
    }
}

if (!function_exists('view_path')) {
    function view_path(string $path = ''): string
    {
        $base = base_path('resources/views');

        return $path ? $base . DIRECTORY_SEPARATOR . $path : $base;
    }
}

if (!function_exists('dd')) {
    function dd(...$vars): void
    {
        echo '<pre>';
        var_dump(...$vars);
        echo '</pre>';
        exit;
    }
}