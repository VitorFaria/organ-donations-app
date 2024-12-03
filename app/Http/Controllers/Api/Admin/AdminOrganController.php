<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\AdminOrganStoreRequest;
use App\Http\Requests\Admin\AdminOrganUpdateRequest;
use App\Http\Resources\Admin\AdminOrganResource;
use App\Repositories\OrganRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdminOrganController extends ApiController
{
    public function __construct(private OrganRepository $organRepository){}
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $organs = $this->organRepository->findAll();

        return AdminOrganResource::collection($organs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminOrganStoreRequest $request): JsonResponse
    {
        $this->organRepository->store($request->validated());

        if (!$this->organRepository->getStatus()) {
            return $this->errorResponse(
                $this->organRepository->getErrorMessage(),
                $this->organRepository->getStatusCode()
            );
        }

        return (new AdminOrganResource($this->organRepository->getData()))->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $organ = $this->organRepository->findOrgan($id);

        if (!$this->organRepository->getStatus()) {
            return $this->errorResponse(
                $this->organRepository->getErrorMessage(),
                $this->organRepository->getStatusCode()
            );
        }

        return (new AdminOrganResource($organ))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminOrganUpdateRequest $request, string $id): JsonResponse
    {
        $this->organRepository->update($id, $request->validated());

        if (!$this->organRepository->getStatus()) {
            return $this->errorResponse(
                $this->organRepository->getErrorMessage(),
                $this->organRepository->getStatusCode()
            );
        }

        $organ = $this->organRepository->getData();

        return (new AdminOrganResource($organ))->response();
    }
}
