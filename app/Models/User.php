<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

    /**
     * @method \Spatie\Permission\Collections\RoleCollection getRoleNames()
     */
    /**
     * @method bool hasRole(string|array $roles)
     * @method void assignRole(string|array $roles)
     */


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    // tambahkan ini supaya Spatie tahu pakai guard 'web'
    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'requested_role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}