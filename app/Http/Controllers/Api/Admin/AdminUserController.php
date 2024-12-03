<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\Role;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\AdminUserStoreRequest;
use App\Http\Requests\Admin\AdminUserUpdateRequest;
use App\Http\Resources\Admin\AdminUserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdminUserController extends ApiController
{
    public function __construct(private UserRepository $userRepository){}
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $users = $this->userRepository->findAll();

        return AdminUserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminUserStoreRequest $request): JsonResponse
    {
        $this->userRepository->storeUserByAdmin($request->validated());

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

        return (new AdminUserResource($data))->response();
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

        return (new AdminUserResource($user->load('patient')))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUserUpdateRequest $request, string $id): JsonResponse
    {
        $this->userRepository->updateUserByAdmin($id, $request->validated());

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

        return (new AdminUserResource($data))->response();
    }
}
