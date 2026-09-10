<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveWorkspacePreferenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['prohibited'],
            'name' => ['required', 'string', 'max:100'],
            'default_view' => ['required', Rule::in(['all', 'home', 'office'])],
        ];
    }
}

