<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController; // Ensure you created this!
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\Employee\ProfileController as EmployeeProfileController;
use App\Http\Controllers\Admin\EmployeeManagementController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\LeaveApprovalController;
use App\Http\Controllers\Admin\AppraisalController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Employee\PortalController;
use Illuminate\Support\Facades\Auth;

// --- GUEST ROUTES ---
Route::get('/', function () {
    return redirect()->route('login');
});

// Explicitly defining Login routes to prevent MethodNotAllowed errors
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->prefix('employee')->name('employee.')->group(function () {
    // The main profile route
    Route::get('/profile', [App\Http\Controllers\Employee\ProfileController::class, 'index'])->name('profile.index');
    
    // Future CRUD routes for Employee
    Route::put('/profile/update', [App\Http\Controllers\Employee\ProfileController::class, 'update'])->name('profile.update');
});

// --- AUTHENTICATED USER (STAFF) ROUTES ---
Route::middleware(['auth'])->group(function () {

    // General Dashboard
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

    // Employee Self-Service
    Route::get('/leaves', [LeaveRequestController::class, 'index'])->name('leaves.index');
    Route::post('/leaves/apply', [LeaveRequestController::class, 'store'])->name('leaves.store');
    
    Route::get('/my-payslips', [PayrollController::class, 'index'])->name('employee.payslips');
    Route::get('/my-payslips/{payroll}', [PayrollController::class, 'show'])->name('employee.payslip.view');

    Route::get('/my-performance', function() {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $appraisals = $user->employee->appraisals()->with('kpiGoal')->get();
        return view('employee.performance.index', compact('appraisals'));
    })->name('employee.performance');
});


// --- ADMIN / HR ONLY ROUTES ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
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

    Route::middleware(['auth', 'is_employee'])->prefix('portal')->name('employee.')->group(function () {
    Route::get('/dashboard', [PortalController::class, 'index'])->name('dashboard');
    
    // Leave CRUD
    Route::get('/leaves', [PortalController::class, 'leaves'])->name('leaves.index');
    Route::get('/leaves/create', [PortalController::class, 'createLeave'])->name('leaves.create');
    Route::post('/leaves', [PortalController::class, 'storeLeave'])->name('leaves.store');

    // Payroll
    Route::get('/payroll', [PortalController::class, 'payroll'])->name('payroll.index');
});
});

// require __DIR__.'/auth.php'; // Commented out to prevent route conflicts