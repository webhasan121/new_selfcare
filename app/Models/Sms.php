<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $table = 'sms';


    protected $fillable = [
        'enable_sms',
        'userID',
        'passwd',
        'sms_local_mr_entry',
        'sms_corporate_mr_entry',
        'sms_customer_create',
        'sms_local_bill_gen',
        'sms_corporate_bill_gen',
        'sms_local_other_bill_entry',
        'sms_corporate_other_bill_entry',
        'sms_token_create',
        'sms_token_close',
        'masking',
        'url',
        'service_provider',
    ];

    protected function casts(): array
    {
        return [
            'enable_sms' => 'boolean',
            'sms_local_mr_entry' => 'boolean',
            'sms_corporate_mr_entry' => 'boolean',
            'sms_customer_create' => 'boolean',
            'sms_local_bill_gen' => 'boolean',
            'sms_corporate_bill_gen' => 'boolean',
            'sms_local_other_bill_entry' => 'boolean',
            'sms_corporate_other_bill_entry' => 'boolean',
            'sms_token_create' => 'boolean',
            'sms_token_close' => 'boolean',
        ];
    }
}
