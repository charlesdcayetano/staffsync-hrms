<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\EmployeeProfileController;
use App\Http\Controllers\Admin\EmployeeManagementController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\LeaveApprovalController;
use App\Http\Controllers\Admin\AppraisalController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// --- AUTHENTICATED USER ROUTES ---
Route::middleware(['auth'])->group(function () {

    // Dashboard (General)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [EmployeeProfileController::class, 'index'])->name('index');
        Route::post('/update-personal', [EmployeeProfileController::class, 'updatePersonal'])->name('updatePersonal');
        Route::post('/update-finance', [EmployeeProfileController::class, 'updateFinance'])->name('updateFinance');
        Route::post('/upload-document', [EmployeeProfileController::class, 'uploadDocument'])->name('uploadDocument');
    });

    // Employee Self-Service (Leaves, Payslips, Performance)
    Route::get('/leaves', [LeaveRequestController::class, 'index'])->name('leaves.index');
    Route::post('/leaves/apply', [LeaveRequestController::class, 'store'])->name('leaves.store');
    
    Route::get('/my-payslips', [PayrollController::class, 'index'])->name('employee.payslips');
    Route::get('/my-payslips/{payroll}', [PayrollController::class, 'show'])->name('employee.payslip.view');

    Route::get('/my-performance', function() {
        $appraisals = Auth::user()->employee->appraisals()->with('kpiGoal')->get();
        return view('employee.performance.index', compact('appraisals'));
    })->name('employee.performance');

});

// --- ADMIN / HR ONLY ROUTES ---
// Make sure you have an 'admin' middleware defined in app/Http/Kernel.php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Workforce Management
    Route::resource('employees', EmployeeManagementController::class);
    Route::post('employees/{employee}/status', [EmployeeManagementController::class, 'updateStatus'])->name('employees.status');

    // Payroll Management
    Route::resource('payroll', PayrollController::class);

    // Leave Approvals & Recalls
    Route::prefix('leaves')->name('leaves.')->group(function () {
        Route::get('/', [LeaveApprovalController::class, 'index'])->name('index');
        Route::post('/{leave}/status', [LeaveApprovalController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/{leave}/recall', [LeaveApprovalController::class, 'recall'])->name('recall');
    });

    // Performance Management
    Route::prefix('performance')->name('performance.')->group(function () {
        Route::get('/', [AppraisalController::class, 'index'])->name('index');
        Route::post('/goals', [AppraisalController::class, 'storeGoal'])->name('goals.store');
        Route::post('/appraise', [AppraisalController::class, 'storeAppraisal'])->name('appraise.store');
    });
});

require __DIR__.'/auth.php';