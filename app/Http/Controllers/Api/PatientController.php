<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Patient\PatientDetailsResource;
use App\Repositories\PatientRepository;
use Illuminate\Http\JsonResponse;

class PatientController extends ApiController
{
    public function __construct(private PatientRepository $patientRepository){}

    public function details(string $id): JsonResponse
    {
        $details = $this->patientRepository->patientDetails($id);

        if (!$this->patientRepository->getStatus()) {
            return $this->errorResponse(
                $this->patientRepository->getErrorMessage(),
                $this->patientRepository->getStatusCode()
            );
        }

        return (new PatientDetailsResource(
            $details['patient']['user'],
            $details['patient'],
            $details['patient']['address'],
            $details['hasOrgansSelected']
        ))->response();
    }
}
