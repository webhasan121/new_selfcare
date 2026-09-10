<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['prohibited'],
            'invoice_number' => ['required', 'string', 'max:64', Rule::unique('invoices', 'invoice_number')->ignore((int) $this->route('billing'))],
            'connection_id' => ['required', 'integer', Rule::exists('connections', 'id')->where('user_id', $this->user()->id)],
            'amount' => ['required', 'numeric', 'decimal:0,2', 'gt:0', 'max:9999999999.99'],
            'due_date' => ['required', 'date_format:Y-m-d'],
            'status' => ['prohibited'],
            'subscription_id' => ['prohibited'],
        ];
    }
}

