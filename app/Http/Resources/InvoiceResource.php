<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'connection' => new ConnectionResource($this->whenLoaded('connection')),
            'amount' => $this->amount,
            'due_date' => $this->due_date?->toDateString(),
            'status' => $this->status,
        ];
    }
}

