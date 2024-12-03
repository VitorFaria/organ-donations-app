<?php

namespace App\Enums;

enum BloodType: string
{
  case A_BLOOD = 'A';
  case B_BLOOD = 'B';
  case AB_BLOOD = 'AB';
  case O_BLOOD = 'O';

  public static function mapValuesToCase(string $value): ?self
  {
    $mappedTypes = [
      'A+' => self::A_BLOOD,
      'A-' => self::A_BLOOD,
      'B+' => self::B_BLOOD,
      'B-' => self::B_BLOOD,
      'AB+' => self::AB_BLOOD,
      'AB-' => self::AB_BLOOD,
      'O+' => self::O_BLOOD,
      'O-' => self::O_BLOOD,
    ];

    return $mappedTypes[$value] ?? null;
  }
}