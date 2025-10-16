<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PharmacyController extends Controller
{
    /**
     * Display a listing of medicines.
     */
    public function index(Request $request)
    {
        $query = Medicine::query();

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by low stock
        if ($request->filled('low_stock')) {
            $query->where('stock', '<=', 10);
        }

        $medicines = $query->latest()->paginate(15);
        $lowStockCount = Medicine::where('stock', '<=', 10)->count();

        return view('pharmacy.index', compact('medicines', 'lowStockCount'));
    }

    /**
     * Show the form for creating a new medicine.
     */
    public function create()
    {
        return view('pharmacy.medicines.create');
    }

    /**
     * Store a newly created medicine in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:tablet,capsule,syrup,injection,cream,ointment'],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        Medicine::create($validated);

        return redirect()->route('pharmacy.index')
            ->with('success', 'Obat berhasil ditambahkan!');
    }

    /**
     * Display the specified medicine.
     */
    public function show(Medicine $medicine)
    {
        return view('pharmacy.medicines.show', compact('medicine'));
    }

    /**
     * Show the form for editing the specified medicine.
     */
    public function edit(Medicine $medicine)
    {
        return view('pharmacy.medicines.edit', compact('medicine'));
    }

    /**
     * Update the specified medicine in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:tablet,capsule,syrup,injection,cream,ointment'],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        $medicine->update($validated);

        return redirect()->route('pharmacy.index')
            ->with('success', 'Obat berhasil diupdate!');
    }

    /**
     * Remove the specified medicine from storage.
     */
    public function destroy(Medicine $medicine)
    {
        // Check if medicine is used in any prescriptions
        if ($medicine->prescriptions()->exists()) {
            return back()->with('error', 'Tidak bisa menghapus obat yang sudah digunakan dalam resep!');
        }

        $medicine->delete();

        return redirect()->route('pharmacy.index')
            ->with('success', 'Obat berhasil dihapus!');
    }

    /**
     * Update stock for a medicine.
     */
    public function updateStock(Request $request, Medicine $medicine)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
            'action' => 'required|in:add,set',
        ]);

        if ($request->action === 'add') {
            $medicine->increment('stock', $request->stock);
        } else {
            $medicine->update(['stock' => $request->stock]);
        }

        return back()->with('success', 'Stok berhasil diupdate!');
    }

    /**
     * Dispense a prescription.
     */
    public function dispense(Patient $patient, Prescription $prescription)
    {
        if ($prescription->medicine->stock < $prescription->quantity) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $prescription->update(['dispensed' => true]);
        $prescription->medicine->decrement('stock', $prescription->quantity);

        // Create medical record
        MedicalRecord::create([
            'patient_id' => $patient->id,
            'activity_type' => 'prescription_dispensed',
            'details' => [
                'prescription_id' => $prescription->id,
                'medicine' => $prescription->medicine->name,
                'quantity' => $prescription->quantity,
            ],
            'activity_date' => now(),
        ]);

        return back()->with('success', 'Resep berhasil diserahkan!');
    }
}
