<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'category',
        'sub_category',
        'name',
        'type',
        'value',
        'description',
    ];
}
