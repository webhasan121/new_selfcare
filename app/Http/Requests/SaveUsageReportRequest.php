<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveUsageReportRequest extends FormRequest
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
            'start_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'end_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_date', 'before_or_equal:today'],
        ];
    }
}

