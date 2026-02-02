<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Illuminate\Http\Request;

class TestResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        if (in_array($user->role, ['admin', 'laborant'])) {
            // Admin i laborant vide sve rezultate
            $testResults = TestResult::with(['appointment.patient', 'appointment.testType', 'resultFiles'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            // Pacijent vidi samo rezultate svojih appointmenta
            $testResults = TestResult::whereHas('appointment', function ($query) use ($user) {
                $query->where('patient_id', $user->patient->id);
            })
            ->with(['appointment.patient', 'appointment.testType', 'resultFiles'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        }

        return view('test-results.index', compact('testResults'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $appointments = \App\Models\Appointment::where('status', 'scheduled')
            ->whereDoesntHave('testResult')
            ->with(['patient', 'testType'])
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        return view('test-results.create', compact('appointments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:test_results,appointment_id',
            'result_file' => 'nullable|file|mimes:pdf|max:10240', // max 10MB
            'result_data' => 'nullable|string',
            'publish' => 'nullable|boolean',
        ]);

        // Provjeri da li se nalaz treba objaviti odmah
        $shouldPublish = $request->input('action') === 'publish' || $request->has('publish');

        $testResult = TestResult::create([
            'appointment_id' => $validated['appointment_id'],
            'result_data' => $validated['result_data'] ?? null,
            'status' => 'completed', // Nalaz je uvijek completed kada se kreira
            'completed_at' => now(),
            'published_at' => $shouldPublish ? now() : null,
        ]);

        // Ako je uploadovan PDF fajl, sačuvaj ga
        if ($request->hasFile('result_file')) {
            $file = $request->file('result_file');
            $originalName = $file->getClientOriginalName();
            $mime = $file->getMimeType();
            $size = $file->getSize();

            // Kreiraj direktorijum ako ne postoji
            $directory = "results/{$testResult->id}";
            $path = $file->store($directory, 'local');

            // Sačuvaj u bazu
            \App\Models\ResultFile::create([
                'test_result_id' => $testResult->id,
                'file_path' => $path,
                'file_name' => basename($path),
                'original_name' => $originalName,
                'mime' => $mime,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $size,
            ]);
        }

        $message = $shouldPublish 
            ? 'Nalaz je uspješno kreiran i objavljen.' 
            : 'Nalaz je uspješno kreiran.';

        return redirect()->route('test-results.index')
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $testResult = TestResult::with(['appointment.patient', 'appointment.testType', 'resultFiles'])->findOrFail($id);
        
        $user = auth()->user();
        
        // Provjeri da li pacijent vidi samo rezultate svojih appointmenta
        if ($user->role === 'user' && $user->patient) {
            if ($testResult->appointment->patient_id !== $user->patient->id) {
                abort(403, 'Unauthorized');
            }
        }

        return response()->json($testResult);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TestResult $testResult)
    {
        $testResult->load(['appointment.patient', 'appointment.testType', 'resultFiles']);
        return view('test-results.edit', compact('testResult'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TestResult $testResult)
    {
        $user = auth()->user();
        
        // Provjeri da li pacijent može ažurirati samo rezultate svojih appointmenta
        if ($user->role === 'user' && $user->patient) {
            if ($testResult->appointment->patient_id !== $user->patient->id) {
                abort(403, 'Unauthorized');
            }
        }

        $validated = $request->validate([
            'result_data' => 'nullable|string',
            'status' => 'required|in:pending,completed',
            'completed_at' => 'nullable|date',
        ]);

        $testResult->update($validated);

        return redirect()->route('test-results.index')
            ->with('success', 'Nalaz je uspješno ažuriran.');
    }

    /**
     * Publish the test result.
     */
    public function publish(TestResult $testResult)
    {
        $testResult->update([
            'published_at' => now(),
            'status' => 'completed',
        ]);

        return redirect()->route('test-results.index')
            ->with('success', 'Nalaz je uspješno objavljen.');
    }

    /**
     * Upload file to test result.
     */
    public function uploadFile(Request $request, TestResult $testResult)
    {
        $user = auth()->user();
        
        // Provjeri da li korisnik može uploadovati fajlove
        if ($user->role === 'user' && $user->patient) {
            if ($testResult->appointment->patient_id !== $user->patient->id) {
                abort(403, 'Unauthorized');
            }
        }

        $validated = $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,png,jpeg|max:10240', // max 10MB
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $mime = $file->getMimeType();
        $size = $file->getSize();

        // Kreiraj direktorijum ako ne postoji
        $directory = "results/{$testResult->id}";
        $path = $file->store($directory, 'local');

        // Sačuvaj u bazu
        $resultFile = \App\Models\ResultFile::create([
            'test_result_id' => $testResult->id,
            'file_path' => $path,
            'file_name' => basename($path),
            'original_name' => $originalName,
            'mime' => $mime,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $size,
        ]);

        return redirect()->route('test-results.edit', $testResult)
            ->with('success', 'Fajl je uspješno uploadovan.');
    }

    /**
     * Download file from test result.
     */
    public function downloadFile(TestResult $testResult, $file)
    {
        $file = \App\Models\ResultFile::findOrFail($file);
        
        $user = auth()->user();
        
        // Provjeri da li fajl pripada test resultu
        if ($file->test_result_id !== $testResult->id) {
            abort(404, 'File not found');
        }

        // Provjeri autorizaciju - pacijent može samo svoje fajlove
        if ($user->role === 'user') {
            // Eksplicitno učitaj patient relaciju
            $user->load('patient');
            
            if ($user->patient) {
                $testResult->load('appointment');
                
                // Provjeri da li je nalaz objavljen (pacijenti mogu preuzeti samo objavljene nalaze)
                if (!$testResult->published_at) {
                    abort(403, 'Nalaz nije objavljen.');
                }
                
                if ($testResult->appointment->patient_id !== $user->patient->id) {
                    abort(403, 'Unauthorized');
                }
            } else {
                abort(403, 'Nemate povezan profil pacijenta.');
            }
        }

        // Provjeri da li fajl postoji
        if (!\Storage::disk('local')->exists($file->file_path)) {
            abort(404, 'File not found');
        }

        return \Storage::disk('local')->download($file->file_path, $file->original_name ?? $file->file_name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TestResult $testResult)
    {
        $user = auth()->user();
        
        // Provjeri da li pacijent može brisati samo rezultate svojih appointmenta
        if ($user->role === 'user' && $user->patient) {
            if ($testResult->appointment->patient_id !== $user->patient->id) {
                abort(403, 'Unauthorized');
            }
        }

        $testResult->delete();

        return redirect()->route('test-results.index')
            ->with('success', 'Nalaz je uspješno obrisan.');
    }
}
