<?php

namespace App\Modules\Suppliers\Models;

use App\Core\Model;

/**
 * Supplier model
 */
class Supplier extends Model
{
    protected string $table = 'suppliers';

    /**
     * Fields that can be mass-assigned
     */
    protected array $fillable = [
        'company_name',
        'contact_name',
        'phone',
        'email',
        'address',
        'notes',
        'status'
    ];
}
