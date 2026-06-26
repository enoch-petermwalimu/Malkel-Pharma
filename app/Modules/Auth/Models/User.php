<?php

namespace App\Modules\Auth\Models;

use App\Core\Model;

/**
 * ----------------------------------------------------------------
 * User Model
 * ----------------------------------------------------------------
 * Représente la table users.
 * ----------------------------------------------------------------
 */

class User extends Model
{
    /**
     * Table SQL
     */
    protected string $table = 'users';
}