<?php

namespace App\Http\Controllers;

use App\Models\DoctorModel;
use Illuminate\Http\Request;
use App\Models\RegisterModel;

class DoctorController extends Controller
{
    //

    public function store(Request $request){
        $validate = $request->validate([
            'user_id' => 'required|integer|exists:register,id',
            'doctor_code' => 'required|string',
            'working_day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'status' => 'required|string',
        ]);

         $user = RegisterModel::find($validate['user_id']);

        if ($user->role !== 'doctor') {
        return response()->json([
            'message' => 'Only users with role doctor can be assigned'
        ], 403);
    }

        $doctor = DoctorModel::create([
            'user_id' => $validate['user_id'],
            'doctor_code' => $validate['doctor_code'],
            'working_day' => $validate['working_day'],
            'start_time' => $validate['start_time'],
            'end_time' => $validate['end_time'],
            'status' => $validate['status'],
        ]);

        return response()->json([
            'message' => 'Successfully store data',
            'doctor' => $doctor,
        ]);
    }

    public function delete($id){
        $validate = DoctorModel::with('user')->find($id);
        if (!$validate) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $validate->delete();
        return response()->json(['message' => 'user deleted successfully']);
    }

    public function index(){
         $validate = DoctorModel::with('user')->get();
        return response()->json(['message' => 'User retrieved successfully', 'doctor' => $validate]);
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

    public function update(Request $request, $id){
         $validate = DoctorModel::find($id);


        if (!$validate) {
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

        $validate->update($validated);

        return response()->json(['message' => 'User updated successfully', 'doctor' => $validate]);
    }
}
