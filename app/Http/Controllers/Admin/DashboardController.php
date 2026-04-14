<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_staff' => Employee::count(),
            'on_leave' => Employee::where('status', 'On Leave')->count(),
            'pending_leaves' => LeaveRequest::where('status', 'Pending')->count(),
            'monthly_payout' => Payroll::whereYear('pay_period_end', now()->year)
                ->whereMonth('pay_period_end', now()->month)
                ->sum('net_pay'),
        ];

        $recentLeaves = LeaveRequest::with(['employee', 'leavePlan'])
            ->latest('created_at')
            ->take(5)
            ->get();

        $birthdays = Employee::whereMonth('date_of_birth', now()->month)
            ->orderBy('date_of_birth')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentLeaves', 'birthdays'));
    }
}
