<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\Examination;
use App\Models\StockLog;
use Carbon\Carbon;

class PharmacistController extends Controller
{
    public function dashboard()
    {
        $totalMedicines = Medicine::count();
        $lowStock = Medicine::where('stock', '<=', 10)->count();
        $outOfStock = Medicine::where('stock', '<=', 0)->count();
        $expired = Medicine::where('expired_at', '<', now())->count();

        $waitingPrescriptions = Prescription::whereNull('dispensed_at')->count();
        $dispensedToday = Prescription::whereDate('dispensed_at', today())->count();
        $totalDispensed = Prescription::count();

        $recentPrescriptions = Prescription::with(['examination.patient', 'examination.doctor', 'medicine'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $lowStockMedicines = Medicine::where('stock', '<=', 10)->orderBy('stock')->take(5)->get();
        $expiredMedicines = Medicine::where('expired_at', '<', now())->orderBy('expired_at')->take(5)->get();

        return view('pharmacist.dashboard', compact(
            'totalMedicines', 'lowStock', 'outOfStock', 'expired',
            'waitingPrescriptions', 'dispensedToday', 'totalDispensed',
            'recentPrescriptions', 'lowStockMedicines', 'expiredMedicines'
        ));
    }

    public function prescriptions(Request $request)
    {
        $query = Prescription::with(['examination.patient', 'examination.doctor', 'medicine'])
            ->orderBy('dispensed_at')
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            if ($request->status === 'waiting') {
                $query->whereNull('dispensed_at');
            } elseif ($request->status === 'dispensed') {
                $query->whereNotNull('dispensed_at');
            }
        }

        $prescriptions = $query->paginate(20);
        return view('pharmacist.prescriptions', compact('prescriptions'));
    }

    public function medicines(Request $request)
    {
        $query = Medicine::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        $medicines = $query->orderBy('name')->paginate(20);
        return view('pharmacist.medicines', compact('medicines'));
    }

    public function stockLog()
    {
        $logs = StockLog::with('medicine')->orderByDesc('created_at')->paginate(30);
        return view('pharmacist.stocklog', compact('logs'));
    }

    public function history(Request $request)
    {
        $query = Prescription::with(['examination.patient', 'examination.doctor', 'medicine'])
            ->whereNotNull('dispensed_at')
            ->orderByDesc('dispensed_at');
        if ($request->filled('date')) {
            $query->whereDate('dispensed_at', $request->date);
        }
        $prescriptions = $query->paginate(20);
        return view('pharmacist.history', compact('prescriptions'));
    }

    public function dispense(Prescription $prescription)
    {
        if ($prescription->dispensed_at) {
            return back()->with('info', 'Prescription already dispensed.');
        }
        $prescription->dispensed_at = now();
        $prescription->save();
        // Update stock log
        StockLog::create([
            'medicine_id' => $prescription->medicine_id,
            'type' => 'out',
            'quantity' => $prescription->quantity,
            'description' => 'Dispensed for prescription #' . $prescription->id,
            'created_at' => now(),
        ]);
        // Update medicine stock
        $medicine = $prescription->medicine;
        $medicine->stock = max(0, $medicine->stock - $prescription->quantity);
        $medicine->save();
        return back()->with('success', 'Prescription dispensed and stock updated.');
    }
}
