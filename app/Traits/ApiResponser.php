<?php

namespace App\Traits;

trait ApiResponser 
{
  protected function successResponse(string $message, int $code = 200, array|object $data = [])
  {
    return response()->json([
      'success'  => true,
      'message' => $message,
      'data'    => $data,
    ], $code);
  }

  protected function dataResponse(array|object $data, $code)
  {
    return response()->json([
      'success'  => true,
      'data'    => $data,
    ], $code);
  }

  protected function errorResponse(string $message = null, int $code)
  {
    return response()->json([
      'success' => false,
      'message' => $message
    ], $code);
  }
}