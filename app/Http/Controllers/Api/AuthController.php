<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\User\UserMeResource;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    public function __construct(private UserRepository $userRepository){}

    public function login(LoginRequest $request): JsonResponse
    {
        $this->userRepository->findUserByEmail($request->email);

        if (!$this->userRepository->getStatus()) {
            return $this->errorResponse(
                $this->userRepository->getErrorMessage(),
                $this->userRepository->getStatusCode()
            );
        }

        if (empty($this->userRepository->getData())) 
            return $this->errorResponse("Credenciais inválidas", Response::HTTP_UNAUTHORIZED);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->errorResponse('Credenciais inválidas', Response::HTTP_UNAUTHORIZED);
        }

        $token = $this->userRepository->getData()->createToken('auth_token')->plainTextToken;

        $credentials = [
            'token_type' => 'Bearer',
            'access_token' => $token,
            'sub' => Auth::user()->id,
            'name' => Auth::user()->name,
            'role' => Auth::user()->role
        ];

        return $this->dataResponse($credentials, Response::HTTP_OK);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        auth()->guard('web')->logout();

        return $this->successResponse("Usuário deslogado com sucesso", Response::HTTP_OK);
    }

    public function me(): JsonResponse
    {
        $user = Auth::user();
        $patient = $user->patient()->first();
        $user['patientId'] = !empty($patient) ? $patient->id : null;

        return (new UserMeResource($user))->response();
    }
}
