<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrescriptionModel;

class PrescriptionController extends Controller
{
    // GET ALL
    public function index()
    {
        $prescriptions = PrescriptionModel::with([
            'consultation',
            'patient',
            'doctor'
        ])->get();

        return response()->json([
            'message' => 'All prescriptions retrieved successfully',
            'data' => $prescriptions
        ]);
    }

    // GET BY ID
    public function show($id)
    {
        $prescription = PrescriptionModel::with([
            'consultation',
            'patient',
            'doctor'
        ])->find($id);

        if (!$prescription) {
            return response()->json([
                'message' => 'Prescription not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Prescription retrieved successfully',
            'data' => $prescription
        ]);
    }

    // CREATE
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'consultation_id' => 'required|exists:consultation,id',
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'required|exists:doctor,id',
                'medicine_name' => 'required|string|max:255',
                'dosage' => 'required|string|max:255',
                'duration_time' => 'required|string|max:255',
            ]);

            $prescription = PrescriptionModel::create($validated);

            return response()->json([
                'message' => 'Prescription created successfully',
                'data' => $prescription
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating prescription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $prescription = PrescriptionModel::find($id);

        if (!$prescription) {
            return response()->json([
                'message' => 'Prescription not found'
            ], 404);
        }

        $validated = $request->validate([
            'consultation_id' => 'sometimes|exists:consultation,id',
            'patient_id' => 'sometimes|exists:patients,id',
            'doctor_id' => 'sometimes|exists:doctor,id',
            'medicine_name' => 'sometimes|string|max:255',
            'dosage' => 'sometimes|string|max:255',
            'duration_time' => 'sometimes|string|max:255',
        ]);

        $prescription->update($validated);

        return response()->json([
            'message' => 'Prescription updated successfully',
            'data' => $prescription
        ]);
    }

    // DELETE
    public function delete($id)
    {
        $prescription = PrescriptionModel::find($id);

        if (!$prescription) {
            return response()->json([
                'message' => 'Prescription not found'
            ], 404);
        }

        $prescription->delete();

        return response()->json([
            'message' => 'Prescription deleted successfully'
        ]);
    }
}