<?php

namespace App\Repositories;

use App\Enums\PatientType;
use App\Models\Hospital;
use App\Models\Patient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HospitalRepository extends BaseRepository
{
  public function __construct(
    private AddressRepository $addressRepository,
    private PatientRepository $patientRepository
  ){}

  public function store(array $data): void
  {
    DB::beginTransaction();
    try {
      if (!empty($data['address_id'])) {
        $address = $this->addressRepository->findAddress($data['address_id']);
      }
      else {
        $payload = $this->mountAddressPayload($data);
        $address = $this->addressRepository->insertAddress($payload['address']);
      }
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

      DB::commit();
    } catch(\Exception $e) {
      DB::rollBack();
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
    $hospitals = Hospital::where('status', true)
      ->with('address')
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

  public function getHospitalById(string $id): array|null
  {
    $hospital = $this->findHospital($id);

    if (empty($hospital)) {
      $this->setStatus(false);
      $this->setStatusCode(Response::HTTP_NOT_FOUND);
      $this->setErrorMessage("Hospital não encontrado para visualização");

      return null;
    }

    $this->setStatus(true);
    $donors = null;
    $recipients = null;
    $donors = Patient::with('organs')->where('patient_type', PatientType::DONOR->value)
    ->whereHas('hospitals', function($query) use ($id) {
      $query->where('hospitals.id', $id);
    })->get();

    $recipients = Patient::with('organs')->where('patient_type', PatientType::RECIPIENT->value)
    ->whereHas('hospitals', function($query) use ($id) {
      $query->where('hospitals.id', $id);
    })->get();

    return [
      'hospital' => $hospital,
      'donors'   => $donors,
      'recipients' => $recipients
    ];
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

  public function chooseHospitals(array $hospitalArr): void
  {
    try {
      $patient = Auth::user()->patient()->first();

      if (empty($patient)) {
        $this->setStatus(false);
        $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->setErrorMessage("Dados de paciente não encontrados para atrelar ao hospital.");

        return;
      }

      $patient = $this->attachDetachItems($patient, $hospitalArr['hospitals']);
      $this->setStatus(true);
      $this->setStatusCode(Response::HTTP_CREATED);
      $this->setData($patient);
    } catch (\Exception $e) {
      $this->setStatus(false);
      $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
      $this->setErrorMessage("Não foi possível selecionar os hospitais.");
    }
  }

  private function attachDetachItems(Patient $patient, array $hospitalArr): Patient
  {
    if (!empty($hospitalArr['disconnect'])) {
      $disconnectItems = array_column($hospitalArr['disconnect'], 'id');
      $patient->hospitals()->detach($disconnectItems);
    }

    if (!empty(['connect'])) {
      $connectItems = array_column($hospitalArr['connect'], 'id');
      $patient->hospitals()->attach($connectItems);
    }

    return $patient;
  }

  public function assignOrRemoveHospitalsToUser(array $data)
  {
    try {
      $patient = $this->patientRepository->getPatient($data['patient_id']);
      $patient = $this->attachDetachItems($patient, $data['hospitals']);

      $this->setStatus(true);
      $this->setStatusCode(Response::HTTP_CREATED);
      $this->setSuccessMessage("Hospitais atribuídos/removidos com sucesso.");
    } catch (\Exception $e) {
      $this->setStatus(false);
      $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
      $this->setErrorMessage("Não foi possível atribuir paciente a este hospital.");
    }
  }

  private function mountAddressPayload(array $payload): array
  {
    $data['address'] = [
      'zip_code'=> $payload['zip_code'],
      'street'=> $payload['street'],
      'neighbourhood' => $payload['neighbourhood'],
      'state' => $payload['state'],
      'city' => $payload['city'],
      'house_number' => $payload['house_number'],
      'complement' => $payload['complement']
    ];

    return $data;
  }
}