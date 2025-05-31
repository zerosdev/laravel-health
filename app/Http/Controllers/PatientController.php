<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
                'name' => ['required', 'string', 'max:200'],
                'id_type' => ['required', 'string', 'in:id_card,driving_license'],
                'id_no' => ['required', 'string'],
                'gender' => ['required', 'string', 'in:male,female'],
                'dob' => ['required', 'string', 'date_format:d-m-Y'],
                'address' => ['required', 'string'],
                'medium_acquisition' => ['required', 'string'],
            ],
            [
                // optional: add custom messages
            ]
        );

        $validated['dob'] = Carbon::createFromFormat('d-m-Y', $validated['dob'])->format('Y-m-d');

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
                'name' => ['required', 'string', 'max:200'],
                'id_type' => ['required', 'string', 'in:id_card,driving_license'],
                'id_no' => ['required', 'string'],
                'gender' => ['required', 'string', 'in:male,female'],
                'dob' => ['required', 'string', 'date_format:d-m-Y'],
                'address' => ['required', 'string'],
                'medium_acquisition' => ['required', 'string'],
            ],
            [
                // optional: add custom messages
            ]
        );

        $validated['dob'] = Carbon::createFromFormat('d-m-Y', $validated['dob'])->format('Y-m-d');

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
