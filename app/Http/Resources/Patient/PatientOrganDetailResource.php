<?php

namespace App\Http\Resources\Patient;

use App\Http\Resources\Organ\OrganResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientOrganDetailResource extends JsonResource
{
    private $organs;

    public function __construct($resource, $organs)
    {
        parent::__construct($resource);
        $this->resource = $resource;

        $this->organs = $organs;
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
            'organs' => OrganResource::collection($this->organs)
        ];
    }
}
