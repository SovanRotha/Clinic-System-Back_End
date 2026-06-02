<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppointmentModel;


class AppointmentController extends Controller
{
    // 🔵 SHOW ALL APPOINTMENTS
    public function index()
    {
        $appointments = AppointmentModel::with(['patient', 'doctor'])->get();

        return response()->json([
            'message' => 'All appointments retrieved',
            'data' => $appointments
        ]);
    }

    // 🔵 SHOW BY ID
    public function show($id)
    {
        $appointment = AppointmentModel::with(['patient', 'doctor'])->find($id);

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
    }

    // 🔵 UPDATE
    public function update(Request $request, $id)
    {
        $appointment = AppointmentModel::with(['patient', 'doctor'])->find($id);

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
    }

    // 🔵 DELETE
    public function delete($id)
    {
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
    }
}