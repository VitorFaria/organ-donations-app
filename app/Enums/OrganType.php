<?php

namespace App\Enums;

enum OrganType: string
{
  case NERVOSO      = 'nervoso';
  case DIGESTIVO    = 'digestivo';
  case RESPIRATORIO = 'respiratório';
  case CIRCULATORIO = 'circulatório';
  case URINARIO     = 'urinário';
  case REPRODUTOR   = 'reprodutor';
  case ENDOCRINO    = 'endócrino';
  case TEGUMENTAR   = 'tegumentar';
  case LOCOMOTOR    = 'locomotor';
  case SENSORIAL    = 'sensorial';
}