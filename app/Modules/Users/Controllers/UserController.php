<?php

namespace App\Modules\Users\Controllers;

use App\Core\Controller;

class UserController extends Controller
{
    public function index(): void
    {
        $this->view('users/index');
    }
}
