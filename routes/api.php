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

// Protected routes by role
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
   Route::post('/doctor', [DoctorController::class, 'store']);
   Route::put('/doctor/{id}', [DoctorController::class, 'update']);
   Route::delete('/doctor/{id}', [DoctorController::class, 'delete']);
   Route::get('/doctor', [DoctorController::class, 'index']);
   Route::get('/doctor/{id}', [DoctorController::class, 'show']);
   Route::get('/getDoctor/{userId}' , [DoctorController::class, 'getDoctor']);

   Route::put('/patients/{id}', [PatientController::class, 'update']);
   Route::delete('/patients/{id}', [PatientController::class, 'destroy']);
   Route::post('/patients', [PatientController::class, 'store']);
   Route::get('/patients', [PatientController::class, 'show']);
   Route::get('/patients/{id}', [PatientController::class, 'showById']);
   Route::get('/patient-profile/{userId}', [PatientController::class, 'getProfile']);

   Route::delete('/appointment/{id}' , [AppointmentController::class, 'delete']);
   Route::put('/appointment/{id}', [AppointmentController::class, 'update']);
   Route::post('/appointment' , [AppointmentController::class, 'store']);
   Route::get('/appointment', [AppointmentController::class, 'index']);
   Route::get('/appointment/{id}', [AppointmentController::class, 'show']);
   Route::get('/my-appointments', [AppointmentController::class, 'myAppointments']);
   Route::get('/AppointmentDoctor', [AppointmentController::class, 'AppointmentDoctor']);

   Route::delete('/consultation/{id}', [ConsultationController::class, 'delete']);
   Route::put('/consultation/{id}', [ConsultationController::class, 'update']);
   Route::post('/consultation' , [ConsultationController::class, 'store']);
   Route::get('/consultation' , [ConsultationController::class, 'index']);
   Route::get('/consultation/{id}', [ConsultationController::class, 'show']);
   Route::get('/my-consultations', [ConsultationController::class, 'myConsultations']);
   Route::get('/ConsultationDoctor', [ConsultationController::class, 'ConsultationDoctor']);

   Route::delete('/prescription/{id}', [PrescriptionController::class, 'delete']);
   Route::put('/prescription/{id}', [PrescriptionController::class, 'update']);
   Route::post('/prescription' , [PrescriptionController::class,'store']);
   Route::get('/prescription', [PrescriptionController::class, 'index']);
   Route::get('/prescription/{id}', [PrescriptionController::class, 'show']);
   Route::get('/my-prescriptions', [PrescriptionController::class, 'myPrescriptions']);
   Route::get('/PrescriptionDoctor', [PrescriptionController::class, 'PrescriptionDoctor']);

   Route::put('/bill/{id}' , [BillController::class, 'update']);
   Route::delete('/bill/{id}' , [BillController::class, 'delete']);
   Route::post('/bill', [BillController::class, 'store']);
   Route::get('/bill' , [BillController::class, 'index']);
   Route::get('/bill/{id}', [BillController::class, 'show']);
   Route::get('/my-bills', [BillController::class, 'myBills']);
});

Route::middleware(['auth:sanctum', 'role:doctor,admin'])->group(function () {
    
   Route::get('/patients', [PatientController::class, 'show']);
   Route::get('/patients/{id}', [PatientController::class, 'showById']);
   Route::get('/patient-profile/{userId}', [PatientController::class, 'getProfile']);

   Route::put('/appointment/{id}', [AppointmentController::class, 'update']);
   Route::get('/appointment', [AppointmentController::class, 'index']);
   Route::get('/appointment/{id}', [AppointmentController::class, 'show']);
   Route::get('/my-appointments', [AppointmentController::class, 'myAppointments']);
   Route::get('/AppointmentDoctor', [AppointmentController::class, 'AppointmentDoctor']);
       
   Route::put('/consultation/{id}', [ConsultationController::class, 'update']);
   Route::post('/consultation' , [ConsultationController::class, 'store']);
   Route::get('/consultation' , [ConsultationController::class, 'index']);
   Route::get('/consultation/{id}', [ConsultationController::class, 'show']);
   Route::get('/my-consultations', [ConsultationController::class, 'myConsultations']);
   Route::get('/ConsultationDoctor', [ConsultationController::class, 'ConsultationDoctor']);
   
   Route::put('/prescription/{id}', [PrescriptionController::class, 'update']);
   Route::post('/prescription' , [PrescriptionController::class,'store']);
   Route::get('/prescription', [PrescriptionController::class, 'index']);
   Route::get('/prescription/{id}', [PrescriptionController::class, 'show']);
   Route::get('/my-prescriptions', [PrescriptionController::class, 'myPrescriptions']);
   Route::get('/PrescriptionDoctor', [PrescriptionController::class, 'PrescriptionDoctor']);
});

Route::middleware(['auth:sanctum', 'role:receptionist, admin'])->group(function () {
   Route::get('/doctor', [DoctorController::class, 'index']);
   Route::get('/doctor/{id}', [DoctorController::class, 'show']);
   Route::get('/getDoctor/{userId}' , [DoctorController::class, 'getDoctor']);

   Route::put('/patients/{id}', [PatientController::class, 'update']);
   Route::delete('/patients/{id}', [PatientController::class, 'destroy']);
   Route::post('/patients', [PatientController::class, 'store']);
   Route::get('/patients', [PatientController::class, 'show']);
   Route::get('/patients/{id}', [PatientController::class, 'showById']);
   Route::get('/patient-profile/{userId}', [PatientController::class, 'getProfile']);

   Route::delete('/appointment/{id}' , [AppointmentController::class, 'delete']);
   Route::put('/appointment/{id}', [AppointmentController::class, 'update']);
   Route::post('/appointment' , [AppointmentController::class, 'store']);
   Route::get('/appointment', [AppointmentController::class, 'index']);
   Route::get('/appointment/{id}', [AppointmentController::class, 'show']);
   Route::get('/my-appointments', [AppointmentController::class, 'myAppointments']);
   Route::get('/AppointmentDoctor', [AppointmentController::class, 'AppointmentDoctor']);

   Route::put('/bill/{id}' , [BillController::class, 'update']);
   Route::delete('/bill/{id}' , [BillController::class, 'delete']);
   Route::post('/bill', [BillController::class, 'store']);
   Route::get('/bill' , [BillController::class, 'index']);
   Route::get('/bill/{id}', [BillController::class, 'show']);
   Route::get('/my-bills', [BillController::class, 'myBills']);


});

Route::middleware(['auth:sanctum', 'role:patient, admin'])->group(function(){

   Route::get('/patients/{id}', [PatientController::class, 'showById']);
   Route::put('/patients/{id}', [PatientController::class, 'update']);
   Route::get('/patient-profile/{userId}', [PatientController::class, 'getProfile']);
   
   Route::get('/appointment/{id}', [AppointmentController::class, 'show']);
   Route::get('/my-appointments', [AppointmentController::class, 'myAppointments']);
   Route::get('/AppointmentDoctor', [AppointmentController::class, 'AppointmentDoctor']);

   Route::get('/consultation/{id}', [ConsultationController::class, 'show']);
   Route::get('/my-consultations', [ConsultationController::class, 'myConsultations']);
   Route::get('/ConsultationDoctor', [ConsultationController::class, 'ConsultationDoctor']);

   Route::get('/prescription/{id}', [PrescriptionController::class, 'show']);
   Route::get('/my-prescriptions', [PrescriptionController::class, 'myPrescriptions']);
   Route::get('/PrescriptionDoctor', [PrescriptionController::class, 'PrescriptionDoctor']);

   Route::get('/my-bills', [BillController::class, 'myBills']);
   Route::get('/bill/{id}', [BillController::class, 'show']);
   Route::get('/bill/{id}', [BillController::class, 'show']);
});

Route::post('/register' , [RegisterController::class , 'register']);
Route::post('/login' , [RegisterController::class , 'login'])->name('login');








