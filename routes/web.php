<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\ReferralController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Hospitals - Admin only
    Route::middleware('role:admin')->group(function () {
        Route::resource('hospitals', HospitalController::class);
    });

    // Doctors - Admin only for CRUD
    Route::middleware('role:admin')->group(function () {
        Route::resource('doctors', DoctorController::class);
    });

    // Patients - Admin & Doctor
    Route::middleware('role:admin,doctor')->group(function () {
        Route::resource('patients', PatientController::class);
    });

    // Medical Records - Admin & Doctor can CRUD, Patient can view
    Route::middleware('role:admin,doctor')->group(function () {
        Route::resource('medical-records', MedicalRecordController::class);
    });

    // Patient view of medical records
    Route::middleware('role:patient')->group(function () {
        Route::get('/my-records', [MedicalRecordController::class, 'index'])->name('my-records');
    });

    // Referrals
    Route::middleware('role:admin,doctor')->group(function () {
        Route::resource('referrals', ReferralController::class)->except(['edit', 'update', 'destroy']);
        Route::post('/referrals/{referral}/accept', [ReferralController::class, 'accept'])->name('referrals.accept');
        Route::post('/referrals/{referral}/complete', [ReferralController::class, 'complete'])->name('referrals.complete');
        Route::post('/referrals/{referral}/reject', [ReferralController::class, 'reject'])->name('referrals.reject');
    });

    // Patient view of referrals
    Route::middleware('role:patient')->group(function () {
        Route::get('/my-referrals', [ReferralController::class, 'index'])->name('my-referrals');
    });

    // Hospitals & Doctors view for all authenticated users
    Route::get('/hospitals-list', [HospitalController::class, 'index'])->name('hospitals.list');
    Route::get('/hospitals-list/{hospital}', [HospitalController::class, 'show'])->name('hospitals.detail');
});

require __DIR__.'/auth.php';
