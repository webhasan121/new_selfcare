<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SelfCareIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            // Compatibility for bookmarks created before dedicated page routes.
            'section' => ['nullable', Rule::in(['overview', 'connections', 'billing', 'packages', 'usage', 'support'])],
            'connection' => ['nullable', 'integer', 'min:1'],
            'invoices_page' => ['nullable', 'integer', 'min:1'],
            'payments_page' => ['nullable', 'integer', 'min:1'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
