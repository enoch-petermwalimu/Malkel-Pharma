<?php

namespace App\Modules\Users\Controllers;

use App\Core\Controller;
use App\Modules\Users\Models\User;

class UserController extends Controller
{
    public function index(): void
    {
        $search = $_GET['search'] ?? '';
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 10;
        $offset = ($page - 1) * $limit;

        $users = User::search($search, $limit, $offset);
        $total = User::countSearch($search);
        $pages = (int)ceil($total / $limit);

        $this->view('users/index', [
            'users'  => $users,
            'page'   => $page,
            'pages'  => $pages,
            'search' => $search,
        ]);
    }
}
