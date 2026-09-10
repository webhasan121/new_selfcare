<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    // Ownership foreign keys must be set through trusted relations, not request input.
    protected $fillable = [
        'package_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function connection(): BelongsTo
    {
        return $this->belongsTo(Connection::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
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
        return $query->whereHas('connection', fn (Builder $owner) => $owner->where('user_id', $user->getKey()));
    }
}

