<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Address\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminHospitalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'companyDocument' => $this->company_document,
            'status' => (bool) $this->status,
            'address' => new AddressResource($this->whenLoaded('address')),
        ];
    }
}
