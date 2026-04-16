<?php


namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    // Dashboard / Profile View
    public function index() {
            /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('employee');

        $recentLeaves = LeaveRequest::where('employee_id', $user->employee->id)->latest()->take(3)->get();
        $recentPayroll = Payroll::where('employee_id', $user->employee->id)->latest()->first();
        
        return view('employee.dashboard', compact('user', 'recentLeaves', 'recentPayroll'));
    }

    // Leave Management (CRUD)
    public function leaves() {
        $leaves = LeaveRequest::where('employee_id', Auth::user()->employee->id)->latest()->paginate(5);
        return view('employee.leaves.index', compact('leaves'));
    }

    // Payroll History
    public function payroll() {
        $payrolls = Payroll::where('employee_id', Auth::user()->employee->id)->latest()->get();
        return view('employee.payroll.index', compact('payrolls'));
    }
}