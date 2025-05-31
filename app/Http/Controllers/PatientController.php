<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'sort' => ['nullable', 'string', 'in:asc,desc'],
            'perPage' => ['nullable', 'integer', 'max:100'],
        ]);

        $patients = $request->user()->patients()
            ->orderBy('created_at', $validated['sort'] ?? 'desc')
            ->paginate($validated['perPage'] ?? 15);

        return response()->json([
            'success' => true,
            'data' => $patients,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'medium_acquisition' => ['required', 'string'],
            ],
            [
                'medium_acquisition.required' => 'Medium Acquisition must be filled',
                'medium_acquisition.string' => 'Medium Acquisition is invalid',
            ]
        );

        $newPatient = $request->user()->patients()
            ->create($validated);
            
        return response()->json([
            'success' => true,
            'data' => $newPatient,
        ]);
    }

    public function show(Request $request, string $id)
    {
        $patient = $request->user()->patients()
            ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $patient,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate(
            [
                'medium_acquisition' => ['required', 'string'],
            ],
            [
                'medium_acquisition.required' => 'Medium Acquisition must be filled',
                'medium_acquisition.string' => 'Medium Acquisition is invalid',
            ]
        );

        $request->user()->patients()
            ->where('id', $id)
            ->update($validated);

        $updatedPatient = $request->user()->patients()->find($id);
            
        return response()->json([
            'success' => true,
            'data' => $updatedPatient,
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        $request->user()->patients()
            ->where('id', $id)
            ->delete();
            
        return response()->json([
            'success' => true,
        ]);
    }
}
