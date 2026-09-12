<?php

namespace App\Http\Requests;

use App\Models\SupportTicket;
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
        $ticketOwnerId = $this->user()->id;
        $canChangeStatus = $this->user()->hasAnyRole(['admin', 'support_staff']);

        if (! $this->isMethod('POST')) {
            $ticketOwnerId = SupportTicket::visibleTo($this->user())
                ->whereKey($this->route('support'))
                ->value('user_id') ?? $ticketOwnerId;
        }

        return [
            'user_id' => ['prohibited'],
            'connection_id' => ['required', 'integer', Rule::exists('connections', 'id')->where('user_id', $ticketOwnerId)],
            'subject' => ['required', 'string', 'max:150'],
            'category' => ['required', Rule::in(['connectivity', 'speed', 'billing', 'other'])],
            'description' => ['required', 'string', 'min:10', 'max:10000'],
            'status' => $canChangeStatus
                ? ['sometimes', 'required', Rule::in(['open', 'in_progress', 'resolved', 'closed'])]
                : ['prohibited'],
        ];
    }
}
