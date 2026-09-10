<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkspacePreference extends Model
{
    protected $fillable = ['name', 'default_view'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

