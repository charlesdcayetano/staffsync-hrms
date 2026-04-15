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
            'active_employees' => Employee::where('status', 'Active')->count(),
            'total_payroll' => Payroll::whereMonth('created_at', now()->month)->sum('net_pay'),
            'new_hires' => Employee::whereMonth('created_at', now()->month)->count(),
        ];

        $recentLeaves = LeaveRequest::with('employee')->latest()->take(5)->get();

        $birthdays = Employee::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') >= ?", [now()->format('m-d')])
                ->orderByRaw("DATE_FORMAT(date_of_birth, '%m-%d') ASC")->take(3)->get();
        
        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        $chartData = [45000, 52000, 48000, 61000, 55000, 67000];

        return view('admin.dashboard', compact('stats', 'recentLeaves', 'birthdays', 'chartLabels', 'chartData'));
    }
}
