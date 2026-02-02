<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Test Types API Routes
Route::middleware('auth:sanctum')->group(function () {
    // GET routes - available to all authenticated users
    Route::get('/test-types', [\App\Http\Controllers\Api\TestTypeController::class, 'index']);
    Route::get('/test-types/{id}', [\App\Http\Controllers\Api\TestTypeController::class, 'show']);
    
    // POST/PUT/DELETE routes - only for admin/laborant
    Route::middleware('role:admin,laborant')->group(function () {
        Route::post('/test-types', [\App\Http\Controllers\Api\TestTypeController::class, 'store']);
        Route::put('/test-types/{id}', [\App\Http\Controllers\Api\TestTypeController::class, 'update']);
        Route::delete('/test-types/{id}', [\App\Http\Controllers\Api\TestTypeController::class, 'destroy']);
    });
});
