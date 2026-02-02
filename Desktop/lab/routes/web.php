<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Za pacijente, provjeri da li imaju potrebne podatke
        if ($user->role === 'user') {
            $user->load('patient');
            if ($user->patient) {
                // Provjeri da li pacijent ima JMBG - ako nema, preusmjeri na formu
                if (!$user->patient->jmbg || !$user->patient->phone || !$user->patient->date_of_birth) {
                    return redirect()->route('patient.profile.complete');
                }
                return view('patient.home');
            }
        }
        
        // Za admin/laborant, prikaži normalni dashboard
        return view('dashboard');
    })->name('dashboard');

    // Patients routes (laborant only)
    Route::middleware('role:laborant,admin')->group(function () {
        Route::resource('patients', \App\Http\Controllers\PatientController::class);
    });

    // Test Types routes (laborant only)
    Route::middleware('role:laborant,admin')->group(function () {
        Route::resource('test-types', \App\Http\Controllers\TestTypeController::class);
    });

    // Appointments routes (laborant only)
    Route::middleware('role:laborant,admin')->group(function () {
        Route::resource('appointments', \App\Http\Controllers\AppointmentController::class);
    });

    // Test Results routes (laborant only)
    Route::middleware('role:laborant,admin')->group(function () {
        Route::resource('test-results', \App\Http\Controllers\TestResultController::class);
        Route::post('test-results/{testResult}/publish', [\App\Http\Controllers\TestResultController::class, 'publish'])->name('test-results.publish');
        Route::post('test-results/{testResult}/upload', [\App\Http\Controllers\TestResultController::class, 'uploadFile'])->name('test-results.upload');
        
        // Statistics route
        Route::get('statistics', [\App\Http\Controllers\StatisticsController::class, 'index'])->name('statistics.index');
    });

    // File download route (with authorization check)
    Route::get('results/{testResult}/files/{file}/download', [\App\Http\Controllers\TestResultController::class, 'downloadFile'])
        ->name('test-results.files.download')
        ->where('file', '[0-9]+');

    // Patient routes (for users with patient profile)
    Route::middleware('role:user')->group(function () {
        Route::prefix('patient')->name('patient.')->group(function () {
            Route::get('profile/complete', [\App\Http\Controllers\PatientProfileController::class, 'create'])->name('profile.complete');
            Route::post('profile/complete', [\App\Http\Controllers\PatientProfileController::class, 'store'])->name('profile.store');
            
            Route::resource('appointments', \App\Http\Controllers\PatientAppointmentController::class)->only(['index', 'create', 'store']);
            Route::resource('test-results', \App\Http\Controllers\PatientTestResultController::class)->only(['index', 'show']);
        });
    });

    // Link patient to user (laborant/admin only)
    Route::middleware('role:laborant,admin')->group(function () {
        Route::post('patients/{patient}/link-user', [\App\Http\Controllers\PatientController::class, 'linkUser'])->name('patients.link-user');
    });
});
