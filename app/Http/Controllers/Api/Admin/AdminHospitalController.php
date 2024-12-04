<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\AdminHospitalAssignRequest;
use App\Http\Requests\Admin\AdminHospitalStoreRequest;
use App\Http\Requests\Admin\AdminHospitalUpdateRequest;
use App\Http\Resources\Hospital\HospitalResource;
use App\Repositories\HospitalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdminHospitalController extends ApiController
{
    public function __construct(private HospitalRepository $hospitalRepository){}
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $hospitals = $this->hospitalRepository->findAll();

        return HospitalResource::collection($hospitals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminHospitalStoreRequest $request): JsonResponse
    {
        $this->hospitalRepository->store($request->validated());
        if (!$this->hospitalRepository->getStatus()) {
            return $this->errorResponse(
                $this->hospitalRepository->getErrorMessage(),
                $this->hospitalRepository->getStatusCode()
            );
        }

        $hospital = $this->hospitalRepository->getData();
        return (new HospitalResource($hospital->load('address')))->response();
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminHospitalUpdateRequest $request, string $id): JsonResponse
    {
        $this->hospitalRepository->update($id, $request->validated());

        if (!$this->hospitalRepository->getStatus()) {
            return $this->errorResponse(
                $this->hospitalRepository->getErrorMessage(),
                $this->hospitalRepository->getStatusCode()
            );
        }
     
        $hospital = $this->hospitalRepository->getData();
        return (new HospitalResource($hospital->load('address')))->response();
    }

    public function assignOrRemoveHospitalsToUser(AdminHospitalAssignRequest $request)
    {
        $this->hospitalRepository->assignOrRemoveHospitalsToUser($request->validated());

        if (!$this->hospitalRepository->getStatus()) {
            return $this->errorResponse(
                $this->hospitalRepository->getErrorMessage(),
                $this->hospitalRepository->getStatusCode()
            );
        }

        return $this->successResponse(
            $this->hospitalRepository->getSuccessMessage(),
            $this->hospitalRepository->getStatusCode()
        );
    }
}
