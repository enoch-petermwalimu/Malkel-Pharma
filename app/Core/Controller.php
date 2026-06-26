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

    /**
     * Check if user is authenticated
     */
    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }
    }

    /**
     * Check if user has admin role
     */
    protected function requireAdmin(): void
    {
        $this->requireAuth();

        if ($_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            echo '403 Forbidden: Admin access required';
            exit;
        }
    }

    /**
     * Check if user has pharmacist role
     */
    protected function requirePharmacist(): void
    {
        $this->requireAuth();

        if ($_SESSION['user']['role'] !== 'pharmacist' && $_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            echo '403 Forbidden: Pharmacist access required';
            exit;
        }
    }

    /**
     * Get current user
     */
    protected function currentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Get current user ID
     */
    protected function currentUserId(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }
}
