<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;

class AddressRepository extends BaseRepository
{
  public function store(array $data): void
  {
    try {
      $address = Address::create($data);

      $this->setStatus(true);
      $this->setData($address);
      $this->setStatus(Response::HTTP_CREATED);
    } catch (\Exception $e) {
      $this->setStatus(false);
      $this->setErrorMessage("Não foi possível salvar dados deste endereço");
      $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
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
    $address = Address::find($id);

    if (empty($address)) {
      $this->setStatus(false);
      $this->setStatusCode(Response::HTTP_NOT_FOUND);
      $this->setErrorMessage("Endereço não encontrado");

      return null;
    }

    $this->setStatus(true);
    return $address;
  }
}