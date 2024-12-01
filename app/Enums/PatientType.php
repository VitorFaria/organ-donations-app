<?php

namespace App\Enums;

enum PatientType: string
{
  case DONOR = 'donor';
  case RECIPIENT = 'recipient';
}