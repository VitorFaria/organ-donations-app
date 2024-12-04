<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressRepository extends BaseRepository
{
  public function store(array $data): void
  {
    DB::beginTransaction();
    try {
      $address = $this->insertAddress($data);

      $this->checkRoleBeforeAttachingAddress(Auth::user(), $address->id);

      $this->setStatus(true);
      $this->setData($address);
      $this->setStatus(Response::HTTP_CREATED);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      $this->setStatus(false);
      $this->setErrorMessage("Não foi possível salvar dados deste endereço");
      $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function insertAddress(array $data)
  {
    $address = Address::create($data);

    return $address;
  }

  public function checkRoleBeforeAttachingAddress(User $user, string $addressId): void
  {
    if ($user->role == Role::USER->value) {
      $patient = $user->patient()->first();
      $patient->address_id = $addressId;
      $patient->save();
    }
  }

  public function update(string $id, array $data): void
  {
    try {
      $address = $this->findAddress($id);
      if (empty($address)) return;

      $address->fill($data);
      $address->save();

      $this->setStatus(true);
      $this->setData($address);
      $this->setStatus(Response::HTTP_OK);
    } catch (\Exception $e) {
      $this->setStatus(false);
      $this->setErrorMessage("Não foi possível salvar dados deste endereço");
      $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function findAll(): LengthAwarePaginator
  {
    $addresses = Address::orderBy('state')
      ->orderBy('city')
      ->paginate(10);

    return $addresses;
  }

  public function findAddress(string $id): ?Address
  {
    $user = Auth::user();

    if ($user->role == Role::USER->value) {
      $patientAddress = $user->patient()->first()->address()->first();

      if (empty($patientAddress)) {
        $this->setStatus(false);
        $this->setStatusCode(Response::HTTP_NOT_FOUND);
        $this->setErrorMessage("Endereço não encontrado");
        return null;
      }

      $address = $patientAddress;
    }
    else {
      $address = Address::find($id);
  
      if (empty($address)) {
        $this->setStatus(false);
        $this->setStatusCode(Response::HTTP_NOT_FOUND);
        $this->setErrorMessage("Endereço não encontrado");
  
        return null;
      }
    }

    $this->setStatus(true);
    return $address;
  }
}