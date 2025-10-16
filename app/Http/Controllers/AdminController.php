<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Medicine;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPatients = Patient::count();
        $verifiedPatients = Patient::where('verified', true)->count();
        $pendingPatients = Patient::where('verified', false)->count();
        $totalMedicines = Medicine::count();
        $recentPatients = Patient::latest()->take(5)->get();
        
        // User statistics
        $totalUsers = \App\Models\User::count();
        $totalDoctors = \App\Models\User::where('role', 'doctor')->count();
        $totalNurses = \App\Models\User::where('role', 'nurse')->count();
        $totalPharmacists = \App\Models\User::where('role', 'pharmacist')->count();

        return view('admin.dashboard', compact(
            'totalPatients',
            'verifiedPatients',
            'pendingPatients',
            'totalMedicines',
            'recentPatients',
            'totalUsers',
            'totalDoctors',
            'totalNurses',
            'totalPharmacists'
        ));
    }
}
