<?php

namespace App\Http\Resources\Patient;

use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\User\UserDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientDetailsResource extends JsonResource
{
    private $patient;

    private $address;

    private $hasOrgansSelected;

    public function __construct($resource, $patient, $address, $hasOrgansSelected)
    {
        parent::__construct($resource);
        $this->resource = $resource;

        $this->patient = $patient;
        $this->address = $address;
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
            'user' => new UserDetailsResource($this),
            'patient' => new PatientOrganDetailResource(
                $this->patient, 
                $this->patient->organs,
                $this->patient->hospitals
            ),
            'address' => new AddressResource($this->address),
            'hasOrgansSelected' => $this->hasOrgansSelected
        ];
    }
}
