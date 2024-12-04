<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMeResource extends JsonResource
{
    private $patientId;

    public function __construct($resource, $patientId)
    {
        parent::__construct($resource);
        $this->resource = $resource;

        $this->patientId = $patientId;
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
            'patientId' =>  $this->patientId,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'document' => $this->document,
            'birthDate' => $this->birth_date,
            'isActive' => (bool) $this->is_active,
        ];
    }
}
