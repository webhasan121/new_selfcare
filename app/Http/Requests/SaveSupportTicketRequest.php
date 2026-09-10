<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveSupportTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['prohibited'],
            'connection_id' => ['required', 'integer', Rule::exists('connections', 'id')->where('user_id', $this->user()->id)],
            'subject' => ['required', 'string', 'max:150'],
            'category' => ['required', Rule::in(['connectivity', 'speed', 'billing', 'other'])],
            'description' => ['required', 'string', 'min:10', 'max:10000'],
            'status' => ['prohibited'],
        ];
    }
}

