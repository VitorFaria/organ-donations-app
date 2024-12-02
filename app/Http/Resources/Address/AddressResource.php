<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'zipCode' => $this->zip_code,
            'street' => $this->street,
            'neighbourhood' => $this->neighbourhood,
            'state' => $this->state,
            'city' => $this->city,
            'houseNumber' => $this->house_number,
            'complement' => $this->complement,
        ];
    }
}
