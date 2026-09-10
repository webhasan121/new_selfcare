<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsageReport extends Model
{
    protected $fillable = ['connection_id', 'start_date', 'end_date'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function connection(): BelongsTo
    {
        return $this->belongsTo(Connection::class);
    }

    protected function casts(): array
    {
        return ['start_date' => 'date', 'end_date' => 'date'];
    }
}

