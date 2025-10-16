<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Screening;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NurseController extends Controller
{
    /**
     * Display nurse dashboard.
     */
    public function dashboard()
    {
        $today = Carbon::today();
        
        // Statistics
        $todayPatients = Patient::whereDate('created_at', $today)->count();
        $todayScreenings = Screening::whereDate('created_at', $today)->count();
        $waitingScreening = Patient::whereDoesntHave('screenings')->where('verified', true)->count();
        $completedScreening = Screening::whereDate('created_at', $today)->count();
        
        // Recent patients waiting for screening
        $patientsWaiting = Patient::whereDoesntHave('screenings')
            ->where('verified', true)
            ->latest()
            ->take(10)
            ->get();
        
        // Recent screenings done today
        $recentScreenings = Screening::with('patient')
            ->whereDate('created_at', $today)
            ->latest()
            ->take(10)
            ->get();
        
        return view('nurse.dashboard', compact(
            'todayPatients',
            'todayScreenings',
            'waitingScreening',
            'completedScreening',
            'patientsWaiting',
            'recentScreenings'
        ));
    }

    /**
     * Display list of patients.
     */
    public function patients(Request $request)
    {
        $query = Patient::with('screenings')->where('verified', true);
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('medical_record_number', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Filter by screening status
        if ($request->filled('status')) {
            if ($request->status === 'not_screened') {
                $query->whereDoesntHave('screenings');
            } elseif ($request->status === 'screened') {
                $query->whereHas('screenings');
            }
        }
        
        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        
        $patients = $query->latest()->paginate(15);
        
        return view('nurse.patients.index', compact('patients'));
    }

    /**
     * Show screening history for a patient.
     */
    public function screeningHistory(Patient $patient)
    {
        $screenings = $patient->screenings()
            ->with('user')
            ->latest()
            ->paginate(10);
        
        return view('nurse.patients.screening-history', compact('patient', 'screenings'));
    }
}
