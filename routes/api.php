<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HospitalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function(){
    return 'ok';
});

Route::prefix('auth')->group(function() {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    Route::prefix('addresses')->group(function() {
        Route::get('/{id}', [AddressController::class, 'show']);
        Route::post('', [AddressController::class, 'store']);
        Route::patch('/{id}', [AddressController::class, 'update']);
    });

    Route::prefix('hospitals')->group(function() {
        Route::get('/', [HospitalController::class, 'index']);
        Route::get('/{id}', [HospitalController::class, 'show']);
        Route::post('choose-hospitals', [HospitalController::class, 'chooseHospitals']);
    });
});
