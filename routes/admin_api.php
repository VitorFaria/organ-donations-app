<?php

use App\Http\Controllers\Api\Admin\AdminAuthController;
use App\Http\Controllers\Api\Admin\AdminOrganController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Middleware\CheckRoleBeforeAction;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function() {
  Route::post('login', [AdminAuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function() {
  Route::middleware([CheckRoleBeforeAction::class])->group(function() {
    Route::post('logout', [AdminAuthController::class, 'logout']);
    Route::get('me', [AdminAuthController::class, 'me']);

    Route::prefix('organs')->group(function() {
      Route::get('', [AdminOrganController::class, 'index']);
      Route::get('/{id}', [AdminOrganController::class, 'show']);
      Route::post('', [AdminOrganController::class, 'store']);
      Route::patch('/{id}', [AdminOrganController::class, 'update']);
    });

    Route::prefix('hospitals')->group(function() {
      Route::post('store', [HospitalController::class, 'store']);
    });
  });
});