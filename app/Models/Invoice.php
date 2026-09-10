<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    // Ownership foreign keys must be set through trusted relations, not request input.
    protected $fillable = [
        'subscription_id',
        'invoice_number',
        'amount',
        'due_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'due_date' => 'date',
        ];
    }

    public function connection(): BelongsTo
    {
        return $this->belongsTo(Connection::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function paymentItems(): HasMany
    {
        return $this->hasMany(PaymentItem::class);
    }

    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class, 'payment_items')
            ->withPivot(['id', 'amount'])->withTimestamps();
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

