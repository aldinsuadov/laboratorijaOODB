<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        if (in_array($user->role, ['admin', 'laborant'])) {
            // Admin i laborant vide sve appointmente
            $appointments = Appointment::with(['patient', 'testType', 'testResult'])
                ->orderBy('appointment_date', 'desc')
                ->orderBy('appointment_time', 'desc')
                ->paginate(15);
        } else {
            // Pacijent vidi samo svoje appointmente
            $appointments = Appointment::where('patient_id', $user->patient->id)
                ->with(['patient', 'testType', 'testResult'])
                ->orderBy('appointment_date', 'desc')
                ->orderBy('appointment_time', 'desc')
                ->paginate(15);
        }

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = \App\Models\Patient::orderBy('last_name')->orderBy('first_name')->get();
        $testTypes = \App\Models\TestType::orderBy('name')->get();
        
        return view('appointments.create', compact('patients', 'testTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'test_type_id' => 'required|exists:test_types,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'nullable|in:scheduled,cancelled,done',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Termin je uspješno zakazan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::with(['patient', 'testType', 'testResult'])->findOrFail($id);
        
        $user = auth()->user();
        
        // Provjeri da li pacijent vidi samo svoje appointmente
        if ($user->role === 'user' && $user->patient) {
            if ($appointment->patient_id !== $user->patient->id) {
                abort(403, 'Unauthorized');
            }
        }

        return response()->json($appointment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $patients = \App\Models\Patient::orderBy('last_name')->orderBy('first_name')->get();
        $testTypes = \App\Models\TestType::orderBy('name')->get();
        
        return view('appointments.edit', compact('appointment', 'patients', 'testTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $user = auth()->user();
        
        // Provjeri da li pacijent može ažurirati samo svoje appointmente
        if ($user->role === 'user' && $user->patient) {
            if ($appointment->patient_id !== $user->patient->id) {
                abort(403, 'Unauthorized');
            }
        }

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'test_type_id' => 'required|exists:test_types,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:scheduled,cancelled,done',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Termin je uspješno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $user = auth()->user();
        
        // Provjeri da li pacijent može brisati samo svoje appointmente
        if ($user->role === 'user' && $user->patient) {
            if ($appointment->patient_id !== $user->patient->id) {
                abort(403, 'Unauthorized');
            }
        }

        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Termin je uspješno obrisan.');
    }
}
