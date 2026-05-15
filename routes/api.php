<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DoctorController;
use App\Http\Controllers\API\PatientController;
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\MedicalRecordController;
use App\Http\Controllers\API\FileController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public routes
Route::get('/doctors', [DoctorController::class, 'index']);
Route::get('/doctors/{doctor}', [DoctorController::class, 'show']);
Route::get('/patients', [PatientController::class, 'index']);
Route::get('/patients/{patient}', [PatientController::class, 'show']);
Route::get('/appointments', [AppointmentController::class, 'index']);
Route::get('/appointments/{appointment}', [AppointmentController::class, 'show']);
Route::get('/medical-records', [MedicalRecordController::class, 'index']);
Route::get('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'show']);
Route::get('/files', [FileController::class, 'index']);
Route::get('/files/{file}', [FileController::class, 'show']);
Route::get('/files/{file}/download', [FileController::class, 'download']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/admin-dashboard', function () {
        return response()->json([
            'message' => 'Welcome Admin'
        ]);
    });

    // Doctor CRUD
    Route::post('/doctors', [DoctorController::class, 'store']);
    Route::put('/doctors/{doctor}', [DoctorController::class, 'update']);
    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy']);

    // Patient CRUD
    Route::post('/patients', [PatientController::class, 'store']);
    Route::put('/patients/{patient}', [PatientController::class, 'update']);
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy']);

    // Appointment CRUD
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy']);

    // Medical Record CRUD
    Route::post('/medical-records', [MedicalRecordController::class, 'store']);
    Route::put('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'update']);
    Route::delete('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'destroy']);

    // File CRUD
    Route::post('/files', [FileController::class, 'store']);
    Route::put('/files/{file}', [FileController::class, 'update']);
    Route::delete('/files/{file}', [FileController::class, 'destroy']);

});

Route::middleware(['auth:sanctum', 'role:doctor'])->group(function () {

    Route::get('/doctor-dashboard', function () {
        return response()->json([
            'message' => 'Welcome Doctor'
        ]);
    });

});

Route::middleware(['auth:sanctum', 'role:patient'])->group(function () {

    Route::get('/patient-dashboard', function () {
        return response()->json([
            'message' => 'Welcome Patient'
        ]);
    });

});