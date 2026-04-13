<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveRequestController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::middleware(['auth'])->group(function () {
    // User Routes
    Route::get('/leaves', [LeaveRequestController::class, 'index'])->name('leaves.index');
    Route::post('/leaves/apply', [LeaveRequestController::class, 'store'])->name('leaves.store');

    // Admin/HR Routes
    Route::post('/admin/leaves/{leave}/approve', [LeaveRequestController::class, 'approve'])->name('admin.leaves.approve');
    Route::post('/admin/leaves/{leave}/recall', [LeaveRequestController::class, 'recall'])->name('admin.leaves.recall');
});

require __DIR__.'/auth.php';
