<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDialer extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'password',
        'contact',
        'contact_verification_hash',
        'contact_verified',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'password' => 'encrypted',
            'contact_verified' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
