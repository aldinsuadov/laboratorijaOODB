<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientFormRequest;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::with('user')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(15);

        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientFormRequest $request)
    {
        $patient = Patient::create($request->validated());

        return redirect()->route('patients.index')
            ->with('success', 'Pacijent je uspješno kreiran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient->load(['appointments.testType', 'appointments.testResult']);
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientFormRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        return redirect()->route('patients.index')
            ->with('success', 'Pacijent je uspješno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Pacijent je uspješno obrisan.');
    }

    /**
     * Link patient to user by email.
     */
    public function linkUser(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = \App\Models\User::where('email', $validated['email'])->first();
        
        if ($user->patient) {
            return redirect()->back()
                ->with('error', 'Korisnik je već povezan sa drugim pacijentom.');
        }

        $patient->update(['user_id' => $user->id]);

        return redirect()->back()
            ->with('success', 'Pacijent je uspješno povezan sa korisnikom.');
    }
}
