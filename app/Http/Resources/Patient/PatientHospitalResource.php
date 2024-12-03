<?php

namespace App\Http\Resources\Patient;

use App\Http\Resources\Hospital\HospitalResource;
use App\Http\Resources\User\UserMeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientHospitalResource extends JsonResource
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
            'hospitals' => HospitalResource::collection($this->whenLoaded('hospitals')),
        ];
    }
}
