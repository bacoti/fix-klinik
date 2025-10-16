<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Examination;
use App\Models\Screening;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DoctorController extends Controller
{
    /**
     * Display doctor dashboard.
     */
    public function dashboard()
    {
        $today = Carbon::today();
        
        // Statistics
        $todayPatients = Screening::whereDate('created_at', $today)->count();
        $todayExaminations = Examination::whereDate('created_at', $today)
            ->where('doctor_id', auth()->id())
            ->count();
        
        // Patients ready for examination (has screening, no examination yet today)
        $patientsReady = Patient::whereHas('screenings', function($q) use ($today) {
            $q->whereDate('created_at', $today);
        })
        ->whereDoesntHave('examinations', function($q) use ($today) {
            $q->whereDate('created_at', $today);
        })
        ->count();
        
        $completedExaminations = Examination::where('doctor_id', auth()->id())
            ->whereDate('created_at', $today)
            ->count();
        
        // Recent patients waiting for examination
        $patientsWaiting = Patient::whereHas('screenings', function($q) use ($today) {
            $q->whereDate('created_at', $today);
        })
        ->whereDoesntHave('examinations', function($q) use ($today) {
            $q->whereDate('created_at', $today);
        })
        ->latest()
        ->take(10)
        ->get();
        
        // Recent examinations done today
        $recentExaminations = Examination::with(['patient', 'doctor'])
            ->where('doctor_id', auth()->id())
            ->whereDate('created_at', $today)
            ->latest()
            ->take(10)
            ->get();
        
        return view('doctor.dashboard', compact(
            'todayPatients',
            'todayExaminations',
            'patientsReady',
            'completedExaminations',
            'patientsWaiting',
            'recentExaminations'
        ));
    }

    /**
     * Display list of patients.
     */
    public function patients(Request $request)
    {
        $query = Patient::with(['screenings', 'examinations'])->where('verified', true);
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by examination status
        if ($request->filled('status')) {
            $today = Carbon::today();
            if ($request->status === 'waiting') {
                $query->whereHas('screenings', function($q) use ($today) {
                    $q->whereDate('created_at', $today);
                })
                ->whereDoesntHave('examinations', function($q) use ($today) {
                    $q->whereDate('created_at', $today);
                });
            } elseif ($request->status === 'examined') {
                $query->whereHas('examinations', function($q) use ($today) {
                    $q->whereDate('created_at', $today);
                });
            }
        }
        
        $patients = $query->latest()->paginate(15);
        
        return view('doctor.patients.index', compact('patients'));
    }

    /**
     * Show examination history for a patient.
     */
    public function examinationHistory(Patient $patient)
    {
        $examinations = $patient->examinations()
            ->with(['doctor', 'prescriptions.medicine'])
            ->latest()
            ->paginate(10);
        
        return view('doctor.patients.examination-history', compact('patient', 'examinations'));
    }
}
