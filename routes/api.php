<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultationController;
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

Route::post('/register' , [RegisterController::class , 'register']);
Route::post('/login' , [RegisterController::class , 'login']);


Route::post('/doctor', [DoctorController::class, 'store']);
Route::get('/doctor', [DoctorController::class, 'index']);
Route::put('/doctor/{id}', [DoctorController::class, 'update']);
Route::delete('/doctor/{id}', [DoctorController::class, 'delete']);
Route::get('/doctor/{id}', [DoctorController::class, 'show']);

Route::post('/patients', [PatientController::class, 'store']);
Route::get('/patients', [PatientController::class, 'show']);
Route::get('/patients/{id}', [PatientController::class, 'showById']);
Route::put('/patients/{id}', [PatientController::class, 'update']);
Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

Route::post('/appointment' , [AppointmentController::class, 'store']);
Route::get('/appointment', [AppointmentController::class, 'index']);
Route::delete('/appointment/{id}' , [AppointmentController::class, 'delete']);
Route::put('/appointment/{id}', [AppointmentController::class, 'update']);
Route::get('/appointment/{id}', [AppointmentController::class, 'show']);

Route::post('/consultation' , [ConsultationController::class, 'store']);
Route::get('/consultation' , [ConsultationController::class, 'index']);
Route::delete('/consultation/{id}', [ConsultationController::class, 'delete']);
Route::put('/consultation/{id}', [ConsultationController::class, 'update']);
Route::get('/consultation/{id}', [ConsultationController::class, 'show']);

Route::post('/prescription' , [PrescriptionController::class,'store']);
Route::get('/prescription', [PrescriptionController::class, 'index']);
Route::delete('/prescription/{id}', [PrescriptionController::class, 'delete']);
Route::put('/prescription/{id}', [PrescriptionController::class, 'update']);
Route::get('/prescription/{id}', [PrescriptionController::class, 'show']);

Route::post('/bill' , [BillController::class, 'store']);
Route::get('/bill' , [BillController::class, 'index']);
Route::put('/bill/{id}' , [BillController::class, 'update']);
Route::delete('/bill/{id}' , [BillController::class, 'delete']);
Route::get('/bill/{id}', [BillController::class, 'show']);
