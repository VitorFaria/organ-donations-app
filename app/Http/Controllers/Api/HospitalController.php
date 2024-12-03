<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\HospitalChooseRequest;
use App\Http\Resources\Hospital\HospitalResource;
use App\Http\Resources\Patient\PatientHospitalResource;
use App\Repositories\HospitalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalController extends ApiController
{
    public function __construct(private HospitalRepository $hospitalRepository){}

    public function index(): JsonResource
    {
        $hospitals = $this->hospitalRepository->findAll();

        return HospitalResource::collection($hospitals);
    }

    public function chooseHospitals(HospitalChooseRequest $request)
    {
        $this->hospitalRepository->chooseHospitals($request->validated());

        if (!$this->hospitalRepository->getStatus()) {
            return $this->errorResponse(
                $this->hospitalRepository->getErrorMessage(),
                $this->hospitalRepository->getStatusCode()
            );
        }

        $patient = $this->hospitalRepository->getData();

        return (new PatientHospitalResource($patient->load('user', 'hospitals')))->response();
    }

    public function show(string $id): JsonResponse
    {
        $hospital = $this->hospitalRepository->findHospital($id);

        if (!$this->hospitalRepository->getStatus()) {
            return $this->errorResponse(
                $this->hospitalRepository->getErrorMessage(),
                $this->hospitalRepository->getStatusCode()
            );
        }

        return (new HospitalResource($hospital->load('address')))->response();
    }
}
