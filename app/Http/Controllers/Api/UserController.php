<?php

namespace App\Http\Controllers\Api;

use App\Enums\Role;
use App\Http\Controllers\ApiController;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends ApiController
{
    public function __construct(private UserRepository $userRepository){}
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $users = $this->userRepository->findAll();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function registerUser(UserStoreRequest $request): JsonResponse
    {
        $this->userRepository->storeUser($request->validated());

        if (!$this->userRepository->getStatus()) {
            return $this->errorResponse(
                $this->userRepository->getErrorMessage(),
                $this->userRepository->getStatusCode()
            );
        }

        $data = $this->userRepository->getData();
        if ($data->role == Role::USER->value) {
            $data = $data->load('patient.organs');
        }

        return (new UserResource($data))->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->userRepository->findUser($id);

        if (!$this->userRepository->getStatus()) {
            return $this->errorResponse(
                $this->userRepository->getErrorMessage(),
                $this->userRepository->getStatusCode()
            );
        }

        return (new UserResource($user->load('patient')))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id): JsonResponse
    {
        $this->userRepository->updateUser($id, $request->validated());

        if (!$this->userRepository->getStatus()) {
            return $this->errorResponse(
                $this->userRepository->getErrorMessage(),
                $this->userRepository->getStatusCode()
            );
        }

        $data = $this->userRepository->getData();
        if ($data->role == Role::USER->value) {
            $data = $data->load('patient.organs');
        }

        return (new UserResource($data))->response();
    }
}
