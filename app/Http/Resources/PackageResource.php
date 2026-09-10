<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'speed_mbps' => $this->speed_mbps,
            'price' => $this->price,
            'validity_days' => $this->validity_days,
            'status' => $this->status,
        ];
    }
}

