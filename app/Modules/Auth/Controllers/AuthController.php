<?php

namespace App\Modules\Auth\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Modules\Auth\Services\AuthService;

/**
 * Auth controller
 */
class AuthController extends Controller
{
    protected AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function loginView(): void
    {
        $this->view('auth.login');
    }

    public function login(): void
    {
        $request = new Request();

        $data = $request->body();

        $success =
            $this->service->login(
                $data['email'],
                $data['password']
            );

        if ($success) {
            header('Location: /dashboard');
            exit;
        }

        $this->view('auth.login', [
            'error' => 'Invalid credentials'
        ]);
    }

    public function logout(): void
    {
        $this->service->logout();

        header('Location: /login');
        exit;
    }
}