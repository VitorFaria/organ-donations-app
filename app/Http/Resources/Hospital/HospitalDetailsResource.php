<?php

namespace App\Http\Resources\Hospital;

use App\Http\Resources\Patient\PatientOrganHospitalDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalDetailsResource extends JsonResource
{
    private $patient;

    private $keyType;

    public function __construct($resource, $patient, $keyType)
    {
        parent::__construct($resource);
        $this->resource = $resource;

        $this->patient = $patient;
        $this->keyType = $keyType;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (!empty($this->keyType)) {
            return [
                'hospital' => new HospitalResource($this),
                $this->keyType => PatientOrganHospitalDetails::collection($this->patient)
            ];
        }

        return [
            'hospital' => new HospitalResource($this),
        ];
    }
}
