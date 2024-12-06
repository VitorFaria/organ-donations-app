<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Response;

class PatientRepository extends BaseRepository
{
  public function patientDetails(string $id): ?array
  {
    $patient = Patient::with('user', 'address')->find($id);

    if (empty($patient)) {
      $this->setStatus(false);
      $this->setErrorMessage("Usuário não encontrado");
      $this->setStatusCode(Response::HTTP_NOT_FOUND);

      return null;
    }

    $this->setStatus(true);

    $hasOrgansSelected = false;
    $organs = $patient->organs()->get();
    $hospitals = $patient->hospitals()->with('address')->get();
    $patient['organs'] = $organs;
    $patient['hospitals'] = $hospitals;
    $hasOrgansSelected = $organs->count() > 0;

    return [
      'patient' => $patient,
      'address' => $patient['address'],
      'hasOrgansSelected' => $hasOrgansSelected
    ];
  }

  public function findPatientByUserId(string $userId): Patient
  {
    $user = User::find($userId);
    $patient = $user->patient()->first();

    return $patient;
  }

  public function getPatient(string $patientId): Patient
  {
    $patient = Patient::find($patientId);

    return $patient;
  }
}