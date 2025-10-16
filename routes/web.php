<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->role === 'nurse') {
        return redirect()->route('nurse.dashboard');
    } elseif (auth()->user()->role === 'doctor') {
        return redirect()->route('doctor.dashboard');
    } elseif (auth()->user()->role === 'pharmacist') {
        return redirect()->route('pharmacist.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patient registration (self or admin)
    Route::get('/patient/register', [RegistrationController::class, 'create'])->name('registration.create');
    Route::post('/patient/register', [RegistrationController::class, 'store'])->name('registration.store');

    // Shared routes for authenticated users
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/patients/{patient}/verify', [PatientController::class, 'verify'])->name('patients.verify');
        
        // User Management
        Route::resource('users', UserController::class);
    });

    // Nurse routes
    Route::middleware('role:nurse')->group(function () {
        Route::get('/nurse/dashboard', [NurseController::class, 'dashboard'])->name('nurse.dashboard');
        Route::get('/nurse/patients', [NurseController::class, 'patients'])->name('nurse.patients');
        Route::get('/nurse/patients/{patient}/screening-history', [NurseController::class, 'screeningHistory'])->name('nurse.screening-history');
        
        // Screening Management
        Route::get('/screening', [ScreeningController::class, 'index'])->name('screening.index');
        Route::get('/patients/{patient}/screening', [ScreeningController::class, 'create'])->name('screening.create');
        Route::post('/patients/{patient}/screening', [ScreeningController::class, 'store'])->name('screening.store');
        Route::get('/screening/{screening}', [ScreeningController::class, 'show'])->name('screening.show');
        Route::get('/screening/{screening}/edit', [ScreeningController::class, 'edit'])->name('screening.edit');
        Route::put('/screening/{screening}', [ScreeningController::class, 'update'])->name('screening.update');
        Route::delete('/screening/{screening}', [ScreeningController::class, 'destroy'])->name('screening.destroy');
    });

    // Doctor routes
    Route::middleware('role:doctor')->group(function () {
        Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
        Route::get('/doctor/patients', [DoctorController::class, 'patients'])->name('doctor.patients');
        Route::get('/doctor/patients/{patient}/examination-history', [DoctorController::class, 'examinationHistory'])->name('doctor.examination-history');
        
        // Examination Management
        Route::get('/examination', [ExaminationController::class, 'index'])->name('examination.index');
        Route::get('/patients/{patient}/examination', [ExaminationController::class, 'create'])->name('examination.create');
        Route::post('/patients/{patient}/examination', [ExaminationController::class, 'store'])->name('examination.store');
        Route::get('/examination/{examination}', [ExaminationController::class, 'show'])->name('examination.show');
        Route::get('/examination/{examination}/edit', [ExaminationController::class, 'edit'])->name('examination.edit');
        Route::put('/examination/{examination}', [ExaminationController::class, 'update'])->name('examination.update');
        Route::get('/examinations/{examination}/pdf', [ExaminationController::class, 'downloadPdf'])->name('examination.pdf');
    });

    // Pharmacy routes (Admin & Pharmacist)
    Route::middleware('role:admin,pharmacist')->group(function () {
        Route::get('/pharmacy', [PharmacyController::class, 'index'])->name('pharmacy.index');
        Route::post('/medicines/{medicine}/stock', [PharmacyController::class, 'updateStock'])->name('medicines.updateStock');
        Route::resource('medicines', PharmacyController::class)->except(['index']);
    });

    // Pharmacist only routes
        Route::middleware('role:pharmacist')->group(function () {
            Route::get('/pharmacist/dashboard', [\App\Http\Controllers\PharmacistController::class, 'dashboard'])->name('pharmacist.dashboard');
            Route::get('/pharmacist/prescriptions', [\App\Http\Controllers\PharmacistController::class, 'prescriptions'])->name('pharmacist.prescriptions');
            Route::post('/pharmacist/prescriptions/{prescription}/dispense', [\App\Http\Controllers\PharmacistController::class, 'dispense'])->name('pharmacist.dispense');
            Route::get('/pharmacist/medicines', [\App\Http\Controllers\PharmacistController::class, 'medicines'])->name('pharmacist.medicines');
            Route::get('/pharmacist/stocklog', [\App\Http\Controllers\PharmacistController::class, 'stockLog'])->name('pharmacist.stocklog');
            Route::get('/pharmacist/history', [\App\Http\Controllers\PharmacistController::class, 'history'])->name('pharmacist.history');
        });
});

require __DIR__.'/auth.php';
