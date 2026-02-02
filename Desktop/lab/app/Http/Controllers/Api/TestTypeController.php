<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestTypeResource;
use App\Models\TestType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class TestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $testTypes = TestType::orderBy('name')->get();
        
        return response()->json([
            'success' => true,
            'data' => TestTypeResource::collection($testTypes),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
            ]);

            $testType = TestType::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Tip testa je uspješno kreiran.',
                'data' => new TestTypeResource($testType),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validacija neuspješna.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $testType = TestType::find($id);

        if (!$testType) {
            return response()->json([
                'success' => false,
                'message' => 'Tip testa nije pronađen.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new TestTypeResource($testType),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $testType = TestType::find($id);

        if (!$testType) {
            return response()->json([
                'success' => false,
                'message' => 'Tip testa nije pronađen.',
            ], 404);
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
            ]);

            $testType->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Tip testa je uspješno ažuriran.',
                'data' => new TestTypeResource($testType),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validacija neuspješna.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $testType = TestType::find($id);

        if (!$testType) {
            return response()->json([
                'success' => false,
                'message' => 'Tip testa nije pronađen.',
            ], 404);
        }

        // Provjeri da li postoje appointmente povezani sa ovim tipom testa
        if ($testType->appointments()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Ne možete obrisati tip testa jer postoje povezani termini.',
            ], 422);
        }

        $testType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tip testa je uspješno obrisan.',
        ]);
    }
}
