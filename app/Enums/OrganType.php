<?php

namespace App\Enums;

enum OrganType: string
{
  case NERVOSO      = 'nervoso';
  case DIGESTIVO    = 'digestivo';
  case RESPIRATORIO = 'respiratorio';
  case CIRCULATORIO = 'circulatorio';
  case URINARIO     = 'urinario';
  case REPRODUTOR   = 'reprodutor';
  case ENDOCRINO    = 'endocrino';
  case TEGUMENTAR   = 'tegumentar';
  case LOCOMOTOR    = 'locomotor';
  case SENSORIAL    = 'sensorial';
}