<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PatientController extends Controller
{
    public function index(): JsonResponse
    {
        $patients = Patient::with('user', 'appointments')->get();
        return response()->json([
            'message' => 'Patients retrieved successfully.',
            'data' => $patients
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('patients', 'public');
        }

        $patient = Patient::create($validated);
        return response()->json([
            'message' => 'Patient created successfully.',
            'data' => $patient
        ], 201);
    }

    public function show(Patient $patient): JsonResponse
    {
        $patient->load('user', 'appointments');
        return response()->json([
            'message' => 'Patient retrieved successfully.',
            'data' => $patient
        ]);
    }

    public function update(Request $request, Patient $patient): JsonResponse
    {
        $validated = $request->validate([
            'date_of_birth' => 'sometimes|date',
            'address' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('patients', 'public');
        }

        $patient->update($validated);
        return response()->json([
            'message' => 'Patient updated successfully.',
            'data' => $patient
        ]);
    }

    public function destroy(Patient $patient): JsonResponse
    {
        $patient->delete();
        return response()->json([
            'message' => 'Patient deleted successfully.'
        ]);
    }
}
