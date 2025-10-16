<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Screening;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class ScreeningController extends Controller
{
    /**
     * Display a listing of screenings.
     */
    public function index(Request $request)
    {
        $query = Screening::with(['patient', 'nurse']);

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Search by patient name or medical record number
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('medical_record_number', 'like', "%{$search}%");
            });
        }

        $screenings = $query->latest()->paginate(15);

        return view('screening.index', compact('screenings'));
    }

    /**
     * Show the form for creating a new screening.
     */
    public function create(Patient $patient)
    {
        // Check if patient already has screening today
        $hasScreeningToday = $patient->screenings()
            ->whereDate('created_at', today())
            ->exists();

        if ($hasScreeningToday) {
            return redirect()->route('nurse.patients')
                ->with('error', 'Pasien sudah melakukan screening hari ini!');
        }

        return view('screening.create', compact('patient'));
    }

    /**
     * Store a newly created screening in storage.
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'temperature' => 'required|numeric|min:30|max:45',
            'blood_pressure_systolic' => 'nullable|integer|min:70|max:250',
            'blood_pressure_diastolic' => 'nullable|integer|min:40|max:150',
            'heart_rate' => 'nullable|integer|min:40|max:200',
            'respiratory_rate' => 'nullable|integer|min:10|max:60',
            'oxygen_saturation' => 'nullable|integer|min:70|max:100',
            'weight' => 'required|numeric|min:1|max:300',
            'height' => 'required|numeric|min:50|max:250',
            'complaints' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $validated['patient_id'] = $patient->id;
        $validated['nurse_id'] = auth()->id();

        $screening = Screening::create($validated);

        // Create medical record
        MedicalRecord::create([
            'patient_id' => $patient->id,
            'activity_type' => 'screening',
            'details' => $validated,
            'activity_date' => now(),
        ]);

        return redirect()->route('nurse.patients')
            ->with('success', 'Screening berhasil disimpan!');
    }

    /**
     * Display the specified screening.
     */
    public function show(Screening $screening)
    {
        $screening->load(['patient', 'nurse']);
        return view('screening.show', compact('screening'));
    }

    /**
     * Show the form for editing the specified screening.
     */
    public function edit(Screening $screening)
    {
        return view('screening.edit', compact('screening'));
    }

    /**
     * Update the specified screening in storage.
     */
    public function update(Request $request, Screening $screening)
    {
        $validated = $request->validate([
            'temperature' => 'required|numeric|min:30|max:45',
            'blood_pressure_systolic' => 'nullable|integer|min:70|max:250',
            'blood_pressure_diastolic' => 'nullable|integer|min:40|max:150',
            'heart_rate' => 'nullable|integer|min:40|max:200',
            'respiratory_rate' => 'nullable|integer|min:10|max:60',
            'oxygen_saturation' => 'nullable|integer|min:70|max:100',
            'weight' => 'required|numeric|min:1|max:300',
            'height' => 'required|numeric|min:50|max:250',
            'complaints' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $screening->update($validated);

        return redirect()->route('screening.show', $screening)
            ->with('success', 'Screening berhasil diupdate!');
    }

    /**
     * Remove the specified screening from storage.
     */
    public function destroy(Screening $screening)
    {
        $screening->delete();

        return redirect()->route('screening.index')
            ->with('success', 'Screening berhasil dihapus!');
    }
}
