<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\Patient;

class AppointmentController extends Controller
{
    // 🔵 SHOW ALL APPOINTMENTS
    public function index()
    {
        $appointments = AppointmentModel::with(['patient', 'doctor' , 'user'])->get();

        return response()->json([
            'message' => 'All appointments retrieved',
            'data' => $appointments
        ]);
    }

    // 🔵 SHOW BY ID
    public function show($id)
    {
        $appointment = AppointmentModel::with(['patient', 'doctor', 'user'])->find($id);

        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Appointment found',
            'data' => $appointment
        ]);
    }

    // 🔵 STORE (CREATE)
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'required|exists:doctor,id',
                'appointment_date' => 'required|date',
                'appointment_time' => 'required|date_format:H:i',
                'reason' => 'nullable|string',
                'status' => 'nullable|in:pending,confirmed,completed,cancelled',
            ]);

            $appointment = AppointmentModel::create($validated);

            return response()->json([
                'message' => 'Appointment created successfully',
                'data' => $appointment
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Failed to create appointment',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // 🔵 UPDATE
    public function update(Request $request, $id)
    {
        try {
            $appointment = AppointmentModel::with(['patient', 'doctor', 'user'])->find($id);

            if (!$appointment) {
                return response()->json([
                    'message' => 'Appointment not found'
                ], 404);
            }

            $validated = $request->validate([
                'patient_id' => 'sometimes|exists:patients,id',
                'doctor_id' => 'sometimes|exists:doctor,id',
                'appointment_date' => 'sometimes|date',
                'appointment_time' => 'sometimes|date_format:H:i',
                'reason' => 'nullable|string',
                'status' => 'nullable|in:pending,confirmed,completed,cancelled',
            ]);

            $appointment->update($validated);

            return response()->json([
                'message' => 'Appointment updated successfully',
                'data' => $appointment
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Failed to update appointment',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // 🔵 DELETE
    public function delete($id)
    {
        try {
            $appointment = AppointmentModel::find($id);

            if (!$appointment) {
                return response()->json([
                    'message' => 'Appointment not found'
                ], 404);
            }

            $appointment->delete();

            return response()->json([
                'message' => 'Appointment deleted successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Failed to delete appointment',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function myAppointments(Request $request)
    {
        
    $patient = Patient::where('user_id', $request->user()->id)->first();

    return AppointmentModel::with(['patient', 'doctor', 'user'])
        ->where('patient_id', $patient->id)
        ->get();
    }

    public function appointmentDoctor(Request $request){
        try{

        $doctor = DoctorModel::where('user_id', $request->user()->id)->first();

        return AppointmentModel::with(['doctor' , 'patient', 'user'])->where('doctor_id', $doctor->id)->get();
        }catch(\Throwable $e){
            return response()->json([
                'message' => 'Failed to retrieve appointments for doctor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

}