<?php

namespace App\Core;

class Auth
{
    public static function user(): ?array
    {
        if (!isset($_SESSION['user'])) {
            return null;
        }

        return $_SESSION['user'];
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function login(array $user): void
    {
        $_SESSION['user'] = $user;
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
    }

    public static function id(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }
}