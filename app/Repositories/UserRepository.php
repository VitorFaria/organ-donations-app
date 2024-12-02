<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Response;

class UserRepository extends BaseRepository
{
  public function findUserByEmailAndRole(string $email, string $role): ?User
  {
    try {
      $user = User::where('email', $email)
        ->where('role', $role)
        ->where('is_active', true)
        ->first();

      $this->setStatus(true);
      $this->setStatusCode(Response::HTTP_OK);
      $this->setData($user);
      return $user;
    } catch (\Throwable $e) {
      $this->setStatus(false);
      $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
      $this->setErrorMessage('Não foi possível encontrar este dado');
    }
  }
}