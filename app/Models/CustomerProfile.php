<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerProfile extends Model
{
    // Ownership foreign keys must be set through trusted relations, not request input.
    protected $fillable = [
        'customer_code',
        'billing_address',
        'billing_phone',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

