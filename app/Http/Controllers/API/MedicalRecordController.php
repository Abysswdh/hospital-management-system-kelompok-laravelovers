<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MedicalRecordController extends Controller
{
    public function index(): JsonResponse
    {
        $records = MedicalRecord::with('appointment')->get();
        return response()->json([
            'message' => 'Medical records retrieved successfully.',
            'data' => $records
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:medical_records',
            'diagnosis' => 'required|string|max:500',
            'treatment' => 'required|string|max:500',
            'prescription' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000'
        ]);

        $record = MedicalRecord::create($validated);
        return response()->json([
            'message' => 'Medical record created successfully.',
            'data' => $record
        ], 201);
    }

    public function show(MedicalRecord $medicalRecord): JsonResponse
    {
        $medicalRecord->load('appointment');
        return response()->json([
            'message' => 'Medical record retrieved successfully.',
            'data' => $medicalRecord
        ]);
    }

    public function update(Request $request, MedicalRecord $medicalRecord): JsonResponse
    {
        $validated = $request->validate([
            'diagnosis' => 'sometimes|string|max:500',
            'treatment' => 'sometimes|string|max:500',
            'prescription' => 'sometimes|nullable|string|max:1000',
            'notes' => 'sometimes|nullable|string|max:1000'
        ]);

        $medicalRecord->update($validated);
        return response()->json([
            'message' => 'Medical record updated successfully.',
            'data' => $medicalRecord
        ]);
    }

    public function destroy(MedicalRecord $medicalRecord): JsonResponse
    {
        $medicalRecord->delete();
        return response()->json([
            'message' => 'Medical record deleted successfully.'
        ]);
    }
}
