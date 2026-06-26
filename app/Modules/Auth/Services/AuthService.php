<?php

namespace App\Modules\Auth\Services;

use App\Modules\Users\Models\User;
use App\Core\Database;
use PDO;

/**
 * Auth service
 */
class AuthService
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Login
     */
    public function login(
        string $email,
        string $password
    ): bool {

        $statement = $this->db->prepare(
            "
            SELECT *
            FROM users
            WHERE email = :email
            LIMIT 1
            "
        );

        $statement->execute([
            'email' => $email
        ]);

        $user =
            $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        if (!$user['is_active']) {
            return false;
        }

        if (!password_verify(
            $password,
            $user['password']
        )) {
            return false;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['full_name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        return true;
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
        session_destroy();
    }

    /**
     * Current user
     */
    public function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Check auth
     */
    public function check(): bool
    {
        return isset($_SESSION['user']);
    }
}