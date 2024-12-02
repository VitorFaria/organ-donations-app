<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\Admin\AdminAuthController;
use App\Http\Controllers\Api\Admin\AdminOrganController;
use App\Http\Controllers\Api\Admin\HospitalController;
use App\Http\Middleware\CheckRoleBeforeAction;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function() {
  Route::post('login', [AdminAuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function() {
  Route::middleware([CheckRoleBeforeAction::class])->group(function() {
    Route::post('logout', [AdminAuthController::class, 'logout']);
    Route::get('me', [AdminAuthController::class, 'me']);

    Route::prefix('addresses')->group(function() {
      Route::get('', [AddressController::class, 'index']);
      Route::get('/{id}', [AddressController::class, 'show']);
      Route::post('', [AddressController::class, 'store']);
      Route::patch('/{id}', [AddressController::class, 'update']);
    });

    Route::prefix('organs')->group(function() {
      Route::get('', [AdminOrganController::class, 'index']);
      Route::get('/{id}', [AdminOrganController::class, 'show']);
      Route::post('', [AdminOrganController::class, 'store']);
      Route::patch('/{id}', [AdminOrganController::class, 'update']);
    });

    Route::prefix('hospitals')->group(function() {
      Route::get('', [HospitalController::class, 'index']);
      Route::get('/{id}', [HospitalController::class, 'show']);
      Route::post('', [HospitalController::class, 'store']);
      Route::patch('/{id}', [HospitalController::class, 'update']);
    });
  });
});