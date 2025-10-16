<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with statistics.
     */
    public function dashboard()
    {
        $today = Carbon::today();

        // --- Statistics Cards Data ---
        $totalPatients = Patient::count();
        $totalStaff = User::count(); // Menghitung semua user sebagai staff
        $todayRegistrations = Patient::whereDate('created_at', $today)->count();
        $todayExaminations = Examination::whereDate('created_at', $today)->count();

        // --- Recent Activity Data ---
        $recentPatients = Patient::latest()->take(5)->get();
        $recentStaff = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPatients',
            'totalStaff',
            'todayRegistrations',
            'todayExaminations',
            'recentPatients',
            'recentStaff'
        ));
    }
}