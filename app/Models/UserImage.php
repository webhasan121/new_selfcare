<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserImage extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'path',
        'file_name',
        'data',
        'is_active',
        'created_by',
        'updated_by',
    ];


    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'is_active' => 'boolean',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Owner of the image.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * User who created the record.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * User who last updated the record.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
