<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'selected_connection_id' => $this->resource['selected']?->id,
            'connections' => ConnectionResource::collection($this->resource['visibleConnections']),
            'recent_invoices' => InvoiceResource::collection($this->resource['invoices']),
            'open_invoice_count' => $this->resource['unpaidCount'],
        ];
    }
}

