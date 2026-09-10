<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $invoices = $this->resource['invoices'];
        $payments = $this->resource['payments'];

        return [
            'selected_connection_id' => $this->resource['selected']?->id,
            'open_invoice_count' => $this->resource['unpaidCount'],
            'invoices' => InvoiceResource::collection($invoices->getCollection()),
            'payments' => PaymentResource::collection($payments->getCollection()),
            'pagination' => [
                'invoices' => ['current_page' => $invoices->currentPage(), 'last_page' => $invoices->lastPage(), 'total' => $invoices->total(), 'next_page_url' => $invoices->nextPageUrl()],
                'payments' => ['current_page' => $payments->currentPage(), 'last_page' => $payments->lastPage(), 'total' => $payments->total(), 'next_page_url' => $payments->nextPageUrl()],
            ],
        ];
    }
}

