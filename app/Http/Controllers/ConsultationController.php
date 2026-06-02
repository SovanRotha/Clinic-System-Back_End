<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultationModel;

class ConsultationController extends Controller
{
    //
    public function index()
    {
        $consultations = ConsultationModel::with(['appointment' , 'doctor' , 'patient'])->get();

        return response()->json([
            'message' => 'All consultations retrieved successfully',
            'data' => $consultations
        ]);
    }

    // Get consultation by ID
    public function show($id)
    {
        $consultation = ConsultationModel::with(['appointment', 'doctor' , 'patient'])->find($id);

        if (!$consultation) {
            return response()->json([
                'message' => 'Consultation not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Consultation retrieved successfully',
            'data' => $consultation
        ]);
    }

    // Create consultation
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'appointment_id' => 'required|exists:appointment,id',
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'required|exists:doctor,id',
                'symptoms' => 'required|string',
                'diagnosis' => 'required|string',
                'note' => 'required|string',
            ]);

            $consultation = ConsultationModel::create($validated);

            return response()->json([
                'message' => 'Consultation created successfully',
                'data' => $consultation
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating consultation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Update consultation
    public function update(Request $request, $id)
    {
        $consultation = ConsultationModel::find($id);

        if (!$consultation) {
            return response()->json([
                'message' => 'Consultation not found'
            ], 404);
        }

        $validated = $request->validate([
            'appointment_id' => 'sometimes|exists:appointment,id',
            'patient_id' => 'sometimes|exists:patients,id',
            'doctor_id' => 'sometimes|exists:doctor,id',
            'symptoms' => 'sometimes|string',
            'diagnosis' => 'sometimes|string',
            'note' => 'sometimes|string',
        ]);

        $consultation->update($validated);

        return response()->json([
            'message' => 'Consultation updated successfully',
            'data' => $consultation
        ]);
    }

    // Delete consultation
    public function delete($id)
    {
        $consultation = ConsultationModel::find($id);

        if (!$consultation) {
            return response()->json([
                'message' => 'Consultation not found'
            ], 404);
        }

        $consultation->delete();

        return response()->json([
            'message' => 'Consultation deleted successfully'
        ]);
    }
}
