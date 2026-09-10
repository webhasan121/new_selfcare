<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    // Ownership foreign keys must be set through trusted relations, not request input.
    protected $fillable = [
        'name',
        'speed_mbps',
        'price',
        'validity_days',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'speed_mbps' => 'integer',
            'price' => 'decimal:2',
            'validity_days' => 'integer',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}

