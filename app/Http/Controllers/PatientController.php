<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    //
    public function store(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required|exists:register,id',
            'patient_code' => 'required|string|max:250',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'blood_group' => 'required|string'

        ]);

        $patient = Patient::create([
            'user_id' => $validate['user_id'],
            'patient_code' => $validate['patient_code'],
            'gender' => $validate['gender'],
            'date_of_birth' => $validate['date_of_birth'],
            'address' => $validate['address'],
            'blood_group' => $validate['blood_group']
        ]);
        return response()->json([
            'message' => 'create patient successfully',
            'data' => $patient
        ]);
    }

    public function show()
    {
        $patients = Patient::all();

        return response()->json([
            'message' => 'All patients retrieved successfully',
            'data' => $patients
        ]);
    }

    public function showById($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Patient retrieved successfully',
            'data' => $patient
        ]);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found'
            ], 404);
        }

        $validate = $request->validate([
            'user_id' => 'required|exists:register,id',
            'patient_code' => 'required|string|max:250',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'blood_group' => 'required|string'
        ]);

        $patient->update($validate);

        return response()->json([
            'message' => 'Patient updated successfully',
            'data' => $patient
        ]);
    }

    public function destroy($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found'
            ], 404);
        }

        $patient->delete();

        return response()->json([
            'message' => 'Patient deleted successfully'
        ]);
    }
}
