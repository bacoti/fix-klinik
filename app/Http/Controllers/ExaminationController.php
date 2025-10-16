<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Examination;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\Screening;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExaminationController extends Controller
{
    public function index(Request $request)
    {
        $query = Examination::with(['patient', 'doctor'])
            ->orderBy('created_at', 'desc');

        if (auth()->user()->role === 'doctor') {
            $query->where('doctor_id', auth()->id());
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $examinations = $query->paginate(15);

        return view('examination.index', compact('examinations'));
    }

    public function show(Examination $examination)
    {
        $examination->load(['patient', 'doctor', 'prescriptions.medicine']);

        // Get latest screening for this patient
        $latestScreening = Screening::where('patient_id', $examination->patient_id)
            ->where('created_at', '<=', $examination->created_at)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('examination.show', compact('examination', 'latestScreening'));
    }

    public function create(Patient $patient)
    {
        // Get latest screening
        $screening = Screening::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Get all available medicines for prescription
        $medicines = Medicine::where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('examination.create', compact('patient', 'screening', 'medicines'));
    }

    public function store(Request $request, Patient $patient)
    {
        $request->validate([
            'anamnesis' => 'required|string',
            'physical_examination' => 'required|string',
            'diagnosis' => 'required|string',
            'prescription_text' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'sick_letter' => 'boolean',
            'sick_days' => 'nullable|integer|min:1|max:30',
            'follow_up_date' => 'nullable|date|after:today',
            'medicines' => 'nullable|array',
            'medicines.*.medicine_id' => 'required_with:medicines|exists:medicines,id',
            'medicines.*.quantity' => 'required_with:medicines|integer|min:1',
            'medicines.*.dosage' => 'required_with:medicines|string',
            'medicines.*.frequency' => 'required_with:medicines|string',
            'medicines.*.duration' => 'required_with:medicines|string',
        ]);

        // Create examination
        $examination = Examination::create([
            'patient_id' => $patient->id,
            'doctor_id' => auth()->id(),
            'anamnesis' => $request->anamnesis,
            'physical_examination' => $request->physical_examination,
            'diagnosis' => $request->diagnosis,
            'prescription_text' => $request->prescription_text,
            'additional_notes' => $request->additional_notes,
            'sick_letter' => $request->has('sick_letter'),
            'sick_days' => $request->sick_days,
            'follow_up_date' => $request->follow_up_date,
        ]);

        // Create prescriptions if medicines added
        if ($request->filled('medicines')) {
            foreach ($request->medicines as $medicineData) {
                Prescription::create([
                    'examination_id' => $examination->id,
                    'medicine_id' => $medicineData['medicine_id'],
                    'quantity' => $medicineData['quantity'],
                    'dosage' => $medicineData['dosage'],
                    'frequency' => $medicineData['frequency'],
                    'duration' => $medicineData['duration'],
                ]);

                // Update medicine stock
                $medicine = Medicine::find($medicineData['medicine_id']);
                if ($medicine) {
                    $medicine->stock -= $medicineData['quantity'];
                    $medicine->save();
                }
            }
        }

        // Create medical record
        MedicalRecord::create([
            'patient_id' => $patient->id,
            'activity_type' => 'examination',
            'details' => json_encode([
                'diagnosis' => $request->diagnosis,
                'sick_letter' => $request->has('sick_letter'),
                'sick_days' => $request->sick_days,
            ]),
            'activity_date' => now(),
        ]);

        return redirect()->route('doctor.patients')->with('success', 'Examination completed successfully');
    }

    public function edit(Examination $examination)
    {
        $patient = $examination->patient;

        // Get latest screening
        $screening = Screening::where('patient_id', $patient->id)
            ->where('created_at', '<=', $examination->created_at)
            ->orderBy('created_at', 'desc')
            ->first();

        // Get all available medicines
        $medicines = Medicine::where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        $examination->load('prescriptions.medicine');

        return view('examination.edit', compact('examination', 'patient', 'screening', 'medicines'));
    }

    public function update(Request $request, Examination $examination)
    {
        $request->validate([
            'anamnesis' => 'required|string',
            'physical_examination' => 'required|string',
            'diagnosis' => 'required|string',
            'prescription_text' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'sick_letter' => 'boolean',
            'sick_days' => 'nullable|integer|min:1|max:30',
            'follow_up_date' => 'nullable|date|after:today',
        ]);

        $examination->update([
            'anamnesis' => $request->anamnesis,
            'physical_examination' => $request->physical_examination,
            'diagnosis' => $request->diagnosis,
            'prescription_text' => $request->prescription_text,
            'additional_notes' => $request->additional_notes,
            'sick_letter' => $request->has('sick_letter'),
            'sick_days' => $request->sick_days,
            'follow_up_date' => $request->follow_up_date,
        ]);

        return redirect()->route('examination.show', $examination)->with('success', 'Examination updated successfully');
    }

    public function downloadPdf(Examination $examination)
    {
        $examination->load(['patient', 'doctor', 'prescriptions.medicine']);

        $pdf = Pdf::loadView('examination.pdf', compact('examination'));
        return $pdf->download('prescription_' . $examination->patient->name . '.pdf');
    }
}
