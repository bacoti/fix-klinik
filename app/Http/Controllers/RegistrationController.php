<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('registration.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
        ]);

        $patient = Patient::create($request->all());

        // Create medical record
        MedicalRecord::create([
            'patient_id' => $patient->id,
            'activity_type' => 'registration',
            'details' => $request->all(),
            'activity_date' => now(),
        ]);

        return redirect()->route('patients.show', $patient)->with('success', 'Patient registered successfully');
    }
}
