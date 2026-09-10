<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    // Ownership foreign keys must be set through trusted relations, not request input.
    protected $fillable = [
        'transaction_id',
        'gateway_transaction_id',
        'total_amount',
        'payment_method',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PaymentItem::class);
    }

    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'payment_items')
            ->withPivot(['id', 'amount'])->withTimestamps();
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

