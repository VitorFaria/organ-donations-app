<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Hospital;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;

class HospitalRepository extends BaseRepository
{
  public function __construct(private AddressRepository $addressRepository){}

  public function store(array $data): void
  {
    try {
      $address = $this->addressRepository->findAddress($data['address_id']);
      $hospitalAlreadyExists = $this->checkIfAddressIdAlreadyExists($address->id);
      
      if ($hospitalAlreadyExists)
        return;

      $hospital = new Hospital([
        'name' => $data['name'],
        'phone' => $data['phone'],
        'email' => $data['email'],
        'company_document' => $data['company_document']
      ]);
      
      $address->hospital()->save($hospital);

      $this->setStatus(true);
      $this->setData($hospital);
      $this->setStatusCode(Response::HTTP_CREATED);
    } catch(\Exception $e) {
      $this->setStatus(false);
      $this->setErrorMessage('Não foi possível cadastrar este hospital');
      $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function checkIfAddressIdAlreadyExists(string $addressId): ?Hospital
  {
    $hospital = Hospital::where('address_id', $addressId)->first();

    if ($hospital) {
      $this->setStatus(false);
      $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
      $this->setErrorMessage("Este endereço já foi utilizado por outro hospital");

      return $hospital;
    }

    $this->setStatus(true);
    return null;
  }

  public function findAll(): LengthAwarePaginator
  {
    $hospitals = Hospital::with('address')
      ->orderBy('name', 'ASC')
      ->paginate(10);

    return $hospitals;
  }

  public function findHospital(string $id): ?Hospital
  {
    $hospital = Hospital::find($id);

    if (empty($hospital)) {
      $this->setStatus(false);
      $this->setStatusCode(Response::HTTP_NOT_FOUND);
      $this->setErrorMessage("Hospital não encontrado");

      return null;
    }

    $this->setStatus(true);
    return $hospital;
  }

  public function update(string $id, array $data): void
  {
    try {
      $hospital = $this->findHospital($id);
      if (empty($hospital)) return;
      
      $address = $this->addressRepository->findAddress($data['address_id']);
      $hospital->fill($data);
      $address->hospital()->save($hospital);

      $this->setStatus(true);
      $this->setData($hospital);
      $this->setStatusCode(Response::HTTP_OK);
    } catch (\Exception $e) {
      $this->setStatus(false);
      $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
      $this->setErrorMessage("Não foi possível atualizar este hospital");
    }
  }
}