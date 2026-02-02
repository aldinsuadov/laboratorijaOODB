<?php

namespace App\Http\Controllers;

use App\Models\TestType;
use Illuminate\Http\Request;

class TestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testTypes = TestType::orderBy('name')->paginate(15);
        return view('test-types.index', compact('testTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('test-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
        ]);

        TestType::create($validated);

        return redirect()->route('test-types.index')
            ->with('success', 'Tip testa je uspješno kreiran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TestType $testType)
    {
        return view('test-types.show', compact('testType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TestType $testType)
    {
        return view('test-types.edit', compact('testType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TestType $testType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
        ]);

        $testType->update($validated);

        return redirect()->route('test-types.index')
            ->with('success', 'Tip testa je uspješno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TestType $testType)
    {
        $testType->delete();

        return redirect()->route('test-types.index')
            ->with('success', 'Tip testa je uspješno obrisan.');
    }
}
