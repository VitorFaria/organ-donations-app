<?php

namespace App\Repositories;

use App\Models\Organ;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;

class OrganRepository extends BaseRepository
{
  public function findAll(): LengthAwarePaginator
  {
    $organs = Organ::orderBy('name', 'ASC')->paginate(10);

    return $organs;
  }

  public function findOrgan(string $id): ?Organ
  {
    $organ = Organ::find($id);
    if (empty($organ)) {
      $this->setStatus(false);
      $this->setErrorMessage("Orgão não encontrado");
      $this->setStatusCode(Response::HTTP_NOT_FOUND);

      return null;
    }
   
    $this->setStatus(true);
    return $organ;
  }

  public function store(array $data): void
  {
    try {
      Organ::create($data);

      $this->setStatus(true);
      $this->setStatusCode(Response::HTTP_CREATED);
      $this->setData($data);
    } catch (\Exception $e) {
      $this->setStatus(false);
      $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
      $this->setErrorMessage("Não foi possível adicionar este orgão");
    }
  }

  public function update(string $id, array $data): void
  {
    try {
      $organ = $this->findOrgan($id);
      if (empty($organ)) return;

      $organ->fill($data);
      $organ->save();

      $this->setStatus(true);
      $this->setData($organ);
      $this->setSuccessMessage("Orgão atualizado com sucesso");
      $this->setStatusCode(Response::HTTP_OK);
    } catch (\Exception $e) {
      $this->setStatus(false);
      $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
      $this->setErrorMessage("Não foi possível atualizar este orgão");
    }
  }
}