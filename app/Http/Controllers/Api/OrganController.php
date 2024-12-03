<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\OrganChooseRequest;
use App\Http\Resources\Patient\PatientOrganResource;
use App\Repositories\OrganRepository;
use Illuminate\Http\JsonResponse;

class OrganController extends ApiController
{
    public function __construct(private OrganRepository $organRepository){}
    public function chooseOrgans(OrganChooseRequest $request): JsonResponse
    {
        $this->organRepository->chooseOrgans($request->validated());

        if (!$this->organRepository->getStatus()) {
            return $this->errorResponse(
                $this->organRepository->getErrorMessage(),
                $this->organRepository->getStatusCode()
            );
        }

        $patient = $this->organRepository->getData();

        return (new PatientOrganResource($patient->load('user', 'organs')))->response();
    }
}
