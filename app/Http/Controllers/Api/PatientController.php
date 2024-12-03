<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Patient\PatientDetailsResource;
use App\Repositories\PatientRepository;
use Illuminate\Http\JsonResponse;

class PatientController extends ApiController
{
    public function __construct(private PatientRepository $patientRepository){}

    public function details(): JsonResponse
    {
        $details = $this->patientRepository->patientDetails();

        return (new PatientDetailsResource(
            $details['user'],
            $details['patient']->load('address'),
            $details['hasOrgansSelected']
        ))->response();
    }
}
