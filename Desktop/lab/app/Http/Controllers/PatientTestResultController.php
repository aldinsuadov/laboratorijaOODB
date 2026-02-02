<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Illuminate\Http\Request;

class PatientTestResultController extends Controller
{
    /**
     * Display a listing of the patient's published test results.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Eksplicitno učitaj patient relaciju
        $user->load('patient');
        
        if (!$user->patient) {
            abort(403, 'Nemate povezan profil pacijenta.');
        }

        // Provjeri da li pacijent ima potrebne podatke
        if (!$user->patient->jmbg || !$user->patient->phone || !$user->patient->date_of_birth) {
            return redirect()->route('patient.profile.complete')
                ->with('warning', 'Molimo vas da prvo dovršite svoj profil.');
        }

        $patientId = $user->patient->id;

        // Prvo dohvatimo appointment IDs za ovog pacijenta
        $appointmentIds = \App\Models\Appointment::where('patient_id', $patientId)
            ->pluck('id')
            ->toArray();

        // Zatim dohvatimo test results za te appointmente koji su objavljeni
        $testResults = TestResult::whereIn('appointment_id', $appointmentIds)
            ->whereNotNull('published_at')
            ->with(['appointment.testType', 'resultFiles'])
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        return view('patient.test-results.index', compact('testResults'));
    }

    /**
     * Display the specified test result.
     */
    public function show(TestResult $testResult)
    {
        $user = auth()->user();
        
        // Eksplicitno učitaj patient relaciju
        $user->load('patient');
        
        if (!$user->patient) {
            abort(403, 'Nemate povezan profil pacijenta.');
        }

        // Provjeri da li je nalaz objavljen i da li pripada pacijentu
        if (!$testResult->published_at) {
            abort(404, 'Nalaz nije objavljen.');
        }

        // Eksplicitno učitaj appointment relaciju
        $testResult->load('appointment');
        
        if ($testResult->appointment->patient_id !== $user->patient->id) {
            abort(403, 'Unauthorized');
        }

        $testResult->load(['appointment.testType', 'resultFiles']);

        return view('patient.test-results.show', compact('testResult'));
    }
}
