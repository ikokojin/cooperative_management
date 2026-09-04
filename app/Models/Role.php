<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_system',
        'sidebar_permissions',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'sidebar_permissions' => 'array',
    ];
}
