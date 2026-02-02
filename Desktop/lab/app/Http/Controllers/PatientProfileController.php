<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientProfileController extends Controller
{
    /**
     * Show the form for completing patient profile.
     */
    public function create()
    {
        $user = auth()->user();
        $user->load('patient');
        
        if (!$user->patient) {
            abort(403, 'Nemate povezan profil pacijenta.');
        }

        return view('patient.profile.complete', [
            'patient' => $user->patient
        ]);
    }

    /**
     * Store additional patient information.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $user->load('patient');
        
        if (!$user->patient) {
            abort(403, 'Nemate povezan profil pacijenta.');
        }

        $validated = $request->validate([
            'jmbg' => [
                'required',
                'string',
                'size:13',
                Rule::unique('patients', 'jmbg')->ignore($user->patient->id),
            ],
            'phone' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
        ], [
            'jmbg.required' => 'JMBG je obavezan.',
            'jmbg.unique' => 'JMBG već postoji u sistemu.',
            'jmbg.size' => 'JMBG mora imati tačno 13 karaktera.',
            'phone.required' => 'Broj telefona je obavezan.',
            'date_of_birth.required' => 'Datum rođenja je obavezan.',
            'date_of_birth.before' => 'Datum rođenja mora biti u prošlosti.',
        ]);

        $user->patient->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Vaši podaci su uspješno sačuvani.');
    }
}
