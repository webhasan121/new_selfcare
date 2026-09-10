<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    protected $table = 'company_infos';


    protected $fillable = [
        'company_name',
        'contact_person',
        'address',
        'display_name',
        'fy_start_date',
        'billing_policy',
        'address_line1',
        'address_line2',
        'address_line3',
        'email',
        'web',
        'contact',
    ];

    protected function casts(): array
    {
        return [
            'fy_start_date' => 'date',
            'billing_policy' => 'integer',
        ];
    }
}
