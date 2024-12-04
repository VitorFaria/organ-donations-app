<?php

namespace App\Http\Resources\Hospital;

use App\Http\Resources\Patient\PatientOrganHospitalDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalDetailsResource extends JsonResource
{
    private $donors;

    private $recipients;

    public function __construct($resource, $donors, $recipients)
    {
        parent::__construct($resource);
        $this->resource = $resource;

        $this->donors = $donors;
        $this->recipients = $recipients;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'hospital' => new HospitalResource($this),
            'donors' => PatientOrganHospitalDetails::collection($this->donors),
            'recipients' => PatientOrganHospitalDetails::collection($this->recipients)
        ];
    }
}
