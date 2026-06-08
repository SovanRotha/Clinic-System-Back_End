<?php

namespace App\Http\Controllers;

use App\Models\DoctorModel;
use Illuminate\Http\Request;
use App\Models\RegisterModel;

class DoctorController extends Controller
{
    //

    public function store(Request $request)
    {
        try{

        
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:register,id',
            'doctor_code' => 'required|string',
            'working_day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'status' => 'required|string',
        ]);

        $user = RegisterModel::find($validated['user_id']);
        if ($user && $user->role !== 'doctor' && $user->role !== 'admin') {
            return response()->json([
                'message' => 'Only users with role doctor or admin can be assigned',
            ], 403);
        }

        $doctor = DoctorModel::create($validated);

        return response()->json([
            'message' => 'Doctor created successfully',
            'doctor' => $doctor,
        ], 201);} catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating doctor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        $doctor = DoctorModel::with('user')->find($id);
        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        $doctor->delete();
        return response()->json(['message' => 'Doctor deleted successfully']);
    }

    public function index()
    {
        $doctors = DoctorModel::with('user')->get();
        return response()->json([
            'message' => 'Doctors retrieved successfully',
            'doctors' => $doctors,
        ]);
    }

    public function show($id){
        $doctor = DoctorModel::with('user')->find($id);

        if (!$doctor) {
            return response()->json([
                'message' => 'Doctor not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Doctor retrieved successfully',
            'doctor' => $doctor,
        ]);
    }

    public function update(Request $request, $id)
    {
        $doctor = DoctorModel::find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        $validated = $request->validate([
            'user_id' => 'required|integer|exists:register,id',
            'doctor_code' => 'required|string',
            'working_day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'status' => 'required|string',
        ]);

        $user = RegisterModel::find($validated['user_id']);
        if ($user && $user->role !== 'doctor' && $user->role !== 'admin') {
            return response()->json([
                'message' => 'Only users with role doctor or admin can be assigned',
            ], 403);
        }

        $doctor->update($validated);

        return response()->json([
            'message' => 'Doctor updated successfully',
            'doctor' => $doctor,
        ]);
    }

    public function getDoctor($userId){
        $doctor = DoctorModel::with('user')
        ->where('user_id', $userId)
        ->first();

    if (!$doctor) {
        return response()->json([
            'message' => 'Patient not found'
        ], 404);
    }

    return response()->json($doctor);
    }
}
