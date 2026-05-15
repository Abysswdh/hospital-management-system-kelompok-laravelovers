<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    public function index(): JsonResponse
    {
        $appointments = Appointment::with('doctor', 'patient', 'medicalRecord')->get();
        return response()->json([
            'message' => 'Appointments retrieved successfully.',
            'data' => $appointments
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date_format:Y-m-d H:i:s|after:now',
            'status' => 'sometimes|in:scheduled,completed,cancelled|default:scheduled',
            'complaint' => 'required|string|max:500'
        ]);

        $appointment = Appointment::create($validated);
        return response()->json([
            'message' => 'Appointment created successfully.',
            'data' => $appointment
        ], 201);
    }

    public function show(Appointment $appointment): JsonResponse
    {
        $appointment->load('doctor', 'patient', 'medicalRecord');
        return response()->json([
            'message' => 'Appointment retrieved successfully.',
            'data' => $appointment
        ]);
    }

    public function update(Request $request, Appointment $appointment): JsonResponse
    {
        $validated = $request->validate([
            'appointment_date' => 'sometimes|date_format:Y-m-d H:i:s',
            'status' => 'sometimes|in:scheduled,completed,cancelled',
            'complaint' => 'sometimes|string|max:500'
        ]);

        $appointment->update($validated);
        return response()->json([
            'message' => 'Appointment updated successfully.',
            'data' => $appointment
        ]);
    }

    public function destroy(Appointment $appointment): JsonResponse
    {
        $appointment->delete();
        return response()->json([
            'message' => 'Appointment deleted successfully.'
        ]);
    }
}
