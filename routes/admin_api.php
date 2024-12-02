<?php

use App\Http\Controllers\Api\Admin\AdminAuthController;
use App\Http\Controllers\Api\HospitalController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function() {
  Route::post('login', [AdminAuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function() {
  Route::post('logout', [AdminAuthController::class, 'logout']);
  Route::get('me', [AdminAuthController::class, 'me']);

  Route::prefix('hospitals')->group(function() {
    Route::post('store', [HospitalController::class, 'store'])->name('hospital.store');
  });
});