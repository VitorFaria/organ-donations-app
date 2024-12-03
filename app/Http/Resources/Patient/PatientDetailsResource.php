<?php

namespace App\Http\Resources\Patient;

use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\User\UserMeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientDetailsResource extends JsonResource
{
    private $patient;

    private $hasOrgansSelected;

    public function __construct($resource, $patient,$hasOrgansSelected)
    {
        parent::__construct($resource);
        $this->resource = $resource;

        $this->patient = $patient;
        $this->hasOrgansSelected = $hasOrgansSelected;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserMeResource($this),
            'patient' => new PatientOrganDetailResource($this->patient, $this->patient->organs),
            'address' => new AddressResource($this->whenLoaded('address')),
            'hasOrgansSelected' => $this->hasOrgansSelected
        ];
    }
}
