<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TestType;
use Illuminate\Http\Request;

class PatientAppointmentController extends Controller
{
    /**
     * Display a listing of the patient's appointments.
     */
    public function index()
    {
        $user = auth()->user();
        $user->load('patient');
        
        if (!$user->patient) {
            abort(403, 'Nemate povezan profil pacijenta.');
        }

        // Provjeri da li pacijent ima potrebne podatke
        if (!$user->patient->jmbg || !$user->patient->phone || !$user->patient->date_of_birth) {
            return redirect()->route('patient.profile.complete')
                ->with('warning', 'Molimo vas da prvo dovršite svoj profil.');
        }

        $appointments = Appointment::where('patient_id', $user->patient->id)
            ->with(['testType', 'testResult'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(15);

        return view('patient.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        $user = auth()->user();
        $user->load('patient');
        
        if (!$user->patient) {
            abort(403, 'Nemate povezan profil pacijenta.');
        }

        // Provjeri da li pacijent ima potrebne podatke
        if (!$user->patient->jmbg || !$user->patient->phone || !$user->patient->date_of_birth) {
            return redirect()->route('patient.profile.complete')
                ->with('warning', 'Molimo vas da prvo dovršite svoj profil prije zakazivanja termina.');
        }

        $testTypes = TestType::orderBy('name')->get();
        
        return view('patient.appointments.create', compact('testTypes'));
    }

    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->patient) {
            abort(403, 'Nemate povezan profil pacijenta.');
        }

        $validated = $request->validate([
            'test_type_id' => 'required|exists:test_types,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        $validated['patient_id'] = $user->patient->id;
        $validated['status'] = 'scheduled';

        $appointment = Appointment::create($validated);

        return redirect()->route('patient.appointments.index')
            ->with('success', 'Termin je uspješno zakazan.');
    }
}
