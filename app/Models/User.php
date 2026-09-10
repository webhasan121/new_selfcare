<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contact',
        'company',
        'message',
        'dob',
        'sex',
        'photo',
        'address',
        'alt_contact',
    ];

    /**
     * Hidden attributes.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'auth_token',
        'contact_verification_hash',
    ];

    /**
     * Attribute casts.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'contact_verified' => 'boolean',
            'active_state' => 'integer',
            'last_login' => 'datetime',
            'dob' => 'date',
        ];
    }

    /**
     * API logs belonging to the user.
     */
    public function apiLogs(): HasMany
    {
        return $this->hasMany(ApiLog::class);
    }

    /**
     * Activity logs belonging to the user.
     */

    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Orders belonging to the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Dialer accounts belonging to the user.
     */
    public function dialers(): HasMany
    {
        return $this->hasMany(UserDialer::class);
    }

    /**
     * Images belonging to the user.
     */
    public function images(): HasMany
    {
        return $this->hasMany(UserImage::class);
    }

    /**
     * User images created by this user.
     */
    public function createdImages(): HasMany
    {
        return $this->hasMany(UserImage::class, 'created_by');
    }

    /**
     * User images updated by this user.
     */
    public function updatedImages(): HasMany
    {
        return $this->hasMany(UserImage::class, 'updated_by');
    }
}
