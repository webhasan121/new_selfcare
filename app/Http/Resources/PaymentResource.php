<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'total_amount' => $this->total_amount,
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'paid_at' => $this->paid_at?->toIso8601String(),
            'allocations' => $this->whenLoaded('items', fn () => $this->items->map(fn ($item) => [
                'invoice_id' => $item->invoice_id,
                'invoice_number' => $item->invoice?->invoice_number,
                'connection_id' => $item->invoice?->connection_id,
                'connection_name' => $item->invoice?->connection?->name,
                'amount' => $item->amount,
            ])),
        ];
    }
}
