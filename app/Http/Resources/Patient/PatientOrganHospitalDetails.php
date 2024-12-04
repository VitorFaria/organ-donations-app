<?php

namespace App\Http\Resources\Patient;

use App\Http\Resources\Organ\OrganResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientOrganHospitalDetails extends JsonResource
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
            'name' => $this->user->name,
            'email' => $this->user->email,
            'isActive' => $this->is_active,
            'patientType' => $this->patient_type,
            'bloodType' => $this->blood_type,
            'organs' => OrganResource::collection($this['organs'])
        ];
    }
}
