<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveConnectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['prohibited'],
            'username' => $this->isMethod('post') ? ['required', 'string', 'max:64'] : ['prohibited'],
            'password' => $this->isMethod('post') ? ['required', 'string', 'max:255'] : ['prohibited'],
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', Rule::in(['home', 'office'])],
            'installation_address' => ['nullable', 'string', 'max:2000'],
            'status' => ['sometimes', 'required', Rule::in(['pending', 'active', 'suspended', 'inactive'])],
        ];
    }
}
