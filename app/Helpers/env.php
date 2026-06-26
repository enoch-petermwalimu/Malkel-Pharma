<?php

if (!function_exists('env')) {

    /**
     * Read environment variables
     */
    function env(string $key, $default = null)
    {
        static $loaded = false;

        if (!$loaded) {

            $path = dirname(__DIR__, 2) . '/.env';

            if (file_exists($path)) {

                $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                foreach ($lines as $line) {

                    $line = trim($line);

                    if (!$line || str_starts_with($line, '#')) {
                        continue;
                    }

                    if (!str_contains($line, '=')) {
                        continue;
                    }

                    [$envKey, $envValue] = explode('=', $line, 2);

                    $_ENV[trim($envKey)] = trim($envValue);
                }
            }

            $loaded = true;
        }

        return $_ENV[$key] ?? $default;
    }
}