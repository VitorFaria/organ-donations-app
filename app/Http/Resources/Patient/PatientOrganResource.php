<?php

namespace App\Http\Resources\Patient;

use App\Http\Resources\Organ\OrganResource;
use App\Http\Resources\User\UserMeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientOrganResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserMeResource($this->whenLoaded('user')),
            'patientType' => $this->patient_type,
            'bloodType' => $this->blood_type,
            'organs' => OrganResource::collection($this->whenLoaded('organs')),
        ];
    }
}
