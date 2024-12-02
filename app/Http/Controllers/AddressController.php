<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressStoreRequest;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Resources\Address\AddressResource;
use App\Repositories\AddressRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AddressController extends ApiController
{
    public function __construct(private AddressRepository $addressRepository) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $addresses = $this->addressRepository->findAll();

        return AddressResource::collection($addresses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressStoreRequest $request): JsonResponse
    {
        $this->addressRepository->store($request->validated());

        if (!$this->addressRepository->getStatus()) {
            return $this->errorResponse(
                $this->addressRepository->getErrorMessage(),
                $this->addressRepository->getStatusCode()
            );
        }

        return (new AddressResource($this->addressRepository->getData()))->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $address = $this->addressRepository->findAddress($id);

        if (!$this->addressRepository->getStatus()) {
            return $this->errorResponse(
                $this->addressRepository->getErrorMessage(),
                $this->addressRepository->getStatusCode()
            );
        }

        return (new AddressResource($address))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressUpdateRequest $request, string $id): JsonResponse
    {
        $this->addressRepository->update($id,$request->validated());

        if (!$this->addressRepository->getStatus()) {
            return $this->errorResponse(
                $this->addressRepository->getErrorMessage(),
                $this->addressRepository->getStatusCode()
            );
        }

        return (new AddressResource($this->addressRepository->getData()))->response();
    }
}
