<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\Admin\AdminAuthController;
use App\Http\Controllers\Api\Admin\AdminHospitalController;
use App\Http\Controllers\Api\Admin\AdminOrganController;
use App\Http\Middleware\CheckRoleBeforeAction;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {
  Route::middleware([CheckRoleBeforeAction::class])->group(function() {
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
      Route::get('', [AdminHospitalController::class, 'index']);
      Route::get('/{id}', [AdminHospitalController::class, 'show']);
      Route::post('', [AdminHospitalController::class, 'store']);
      Route::post('assign-patient', [AdminHospitalController::class, 'assignOrRemoveHospitalsToUser']);
      Route::patch('/{id}', [AdminHospitalController::class, 'update']);
    });
  });
});