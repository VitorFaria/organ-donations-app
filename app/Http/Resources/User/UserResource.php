<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Organ\OrganResource;
use App\Http\Resources\Patient\PatientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'document' => $this->document,
            'role' => $this->role,
            'birthDate' => $this->birth_date,
            'createdAt' => $this->created_at,
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'organs' => $this->when(!empty($this->patient->organs), function() {
                return OrganResource::collection($this->patient->organs);
            }),
        ];
    }
}
