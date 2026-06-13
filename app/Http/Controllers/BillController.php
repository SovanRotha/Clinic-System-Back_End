<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillModel;
use App\Models\Patient;

class BillController extends Controller
{
    // GET ALL BILLS
    public function index()
    {
        $bills = BillModel::with(['patient', 'appointment', 'user'])->get();

        return response()->json([
            'message' => 'All bills retrieved successfully',
            'data' => $bills
        ]);
    }

    // GET BY ID
    public function show($id)
    {
        $bill = BillModel::with(['patient', 'appointment', 'user'])->find($id);

        if (!$bill) {
            return response()->json([
                'message' => 'Bill not found'
            ], 404);
        }

        $user = auth()->user();

        if ($user->role === 'patient') {
            $patient = $user->patient;

            if (!$patient || $bill->patient_id !== $patient->id) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 403);
            }
        }

        return response()->json([
            'message' => 'Bill retrieved successfully',
            'data' => $bill
        ]);
    }

    // CREATE BILL
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'appointment_id' => 'required|exists:appointment,id',
                'register_id' => 'nullable|exists:register,id',
                'consultation_fee' => 'required|numeric',
                'medicine_fee' => 'required|numeric',
                'payment_status' => 'nullable|in:paid,unpaid',
            ]);

            // Auto calculate total
            $validated['total_amount'] = $validated['consultation_fee'] + $validated['medicine_fee'];
            $validated['payment_status'] = $validated['payment_status'] ?? 'unpaid';

            $bill = BillModel::create($validated);

            return response()->json([
                'message' => 'Bill created successfully',
                'data' => $bill
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating bill',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // UPDATE BILL
    public function update(Request $request, $id)
    {
        $bill = BillModel::find($id);

        if (!$bill) {
            return response()->json([
                'message' => 'Bill not found'
            ], 404);
        }

        $validated = $request->validate([
            'patient_id' => 'sometimes|exists:patients,id',
            'appointment_id' => 'sometimes|exists:appointment,id',
            'register_id' => 'sometimes|exists:register,id',
            'consultation_fee' => 'sometimes|numeric',
            'medicine_fee' => 'sometimes|numeric',
            'payment_status' => 'sometimes|in:paid,unpaid',
        ]);

        // Recalculate total if fees are updated
        if (isset($validated['consultation_fee']) || isset($validated['medicine_fee'])) {
            $consultationFee = $validated['consultation_fee'] ?? $bill->consultation_fee;
            $medicineFee = $validated['medicine_fee'] ?? $bill->medicine_fee;

            $validated['total_amount'] = $consultationFee + $medicineFee;
        }

        $bill->update($validated);

        return response()->json([
            'message' => 'Bill updated successfully',
            'data' => $bill
        ]);
    }

    // DELETE BILL
    public function delete($id)
    {
        $bill = BillModel::find($id);

        if (!$bill) {
            return response()->json([
                'message' => 'Bill not found'
            ], 404);
        }

        $bill->delete();

        return response()->json([
            'message' => 'Bill deleted successfully'
        ]);
    }
    public function myBills(Request $request)
    {
        try {
            $user = $request->user();
            $patient = $user->patient ?? Patient::where('user_id', $user->id)->first();

            if (!$patient) {
                return response()->json([
                    'message' => 'Patient record not found for the current user'
                ], 404);
            }

            $bills = BillModel::with(['patient', 'appointment', 'user'])
                ->where('patient_id', $patient->id)
                ->get();

            return response()->json([
                'message' => 'My bills retrieved successfully',
                'data' => $bills
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving bills',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}