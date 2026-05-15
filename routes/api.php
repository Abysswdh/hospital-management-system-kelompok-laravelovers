<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/admin-dashboard', function () {
        return response()->json([
            'message' => 'Welcome Admin'
        ]);
    });

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