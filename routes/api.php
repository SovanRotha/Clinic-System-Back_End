<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);


Route::post('/patients', [PatientController::class, 'store']);
Route::get('/patients', [PatientController::class, 'show']);
Route::get('/patients/{id}', [PatientController::class, 'showById']);
Route::put('/patients/{id}', [PatientController::class, 'update']);
Route::delete('/patients/{id}', [PatientController::class, 'destroy']);



Route::post('/doctor', [DoctorController::class, 'store']);
Route::get('/doctor', [DoctorController::class, 'show']);
Route::put('/doctor/{id}', [DoctorController::class, 'update']);
Route::delete('/doctor/{id}', [DoctorController::class, 'delete']);
