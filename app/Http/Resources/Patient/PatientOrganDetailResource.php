<?php

namespace App\Http\Resources\Patient;

use App\Http\Resources\Hospital\HospitalResource;
use App\Http\Resources\Organ\OrganResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientOrganDetailResource extends JsonResource
{
    private $organs;

    private $hospitals;

    public function __construct($resource, $organs, $hospitals)
    {
        parent::__construct($resource);
        $this->resource = $resource;

        $this->organs = $organs;

        $this->hospitals = $hospitals;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patientType' => $this->patient_type,
            'bloodType' => $this->blood_type,
            'hospitals' => HospitalResource::collection($this->hospitals),
            'organs' => OrganResource::collection($this->organs)
        ];
    }
}
