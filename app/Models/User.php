<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'permission_level' => 0,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company',
        'department',
        'job_title',
        'location_id',
        'desk',
        'state',
        'type',
        'permission_level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Identify whether the current user is an admin with permission level greater than 0.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->permission_level > 0;
    }

    /**
     * Identify whether the current user is an admin manager with permission level greater than 1.
     *
     * @return bool
     */
    public function isAdminManager(): bool
    {
        return $this->permission_level > 1;
    }
}
