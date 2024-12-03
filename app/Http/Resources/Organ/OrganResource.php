<?php

namespace App\Http\Resources\Organ;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganResource extends JsonResource
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
            'organType' => $this->organ_type,
        ];
    }
}
