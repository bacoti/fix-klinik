<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('medicalRecords')->get();
        return view('patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        $patient->load('screenings', 'examinations.prescriptions.medicine', 'medicalRecords');
        return view('patients.show', compact('patient'));
    }

    public function verify(Request $request, Patient $patient)
    {
        $patient->update(['verified' => true]);

        return back()->with('success', 'Patient verified');
    }
}
