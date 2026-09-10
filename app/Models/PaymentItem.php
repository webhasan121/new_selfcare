<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentItem extends Model
{
    // Ownership foreign keys must be set through trusted relations, not request input.
    protected $fillable = [
        'invoice_id',
        'amount',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Use before looking up a customer-supplied ID.
     * Dialer sessions additionally require a server-verified connection restriction.
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('payment', fn (Builder $owner) => $owner->where('user_id', $user->getKey()));
    }
}

