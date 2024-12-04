<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PatientRepository extends BaseRepository
{
  public function patientDetails(): array
  {
    $user = Auth::user();
    $patient = $user->patient()->first();

    $hasOrgansSelected = false;
    if (!empty($patient)) {
      $organs = $patient->organs()->get();
      $patient['organs'] = $organs;
      $hasOrgansSelected = $organs->count() > 0;
    }
    
    return [
      'user' => $user,
      'patient' => $patient,
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