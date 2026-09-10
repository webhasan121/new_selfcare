<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Connection extends Model
{
    // Ownership foreign keys must be set through trusted relations, not request input.
    protected $fillable = [
        'name',
        'username',
        'password',
        'type',
        'installation_address',
        'status',
    ];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return ['password' => 'encrypted'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Use before looking up a customer-supplied ID.
     * Dialer sessions additionally require a server-verified connection restriction.
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->where($query->qualifyColumn('user_id'), $user->getKey());
    }
}
