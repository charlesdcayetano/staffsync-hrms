<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeavePlan;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveRequestController extends Controller
{
    /**
     * Display leave history for the logged-in employee.
     */
    public function index()
    {
        $employee = Auth::user()->employee;
        $leaves = LeaveRequest::where('employee_id', $employee->id)
            ->with(['leavePlan', 'reliefOfficer'])
            ->latest()
            ->get();

        return view('employee.leaves.index', compact('leaves'));
    }

    /**
     * Store a new leave application.
     */
    public function store(Request $request)
    {
        $request->validate([
            'leave_plan_id' => 'required|exists:leave_plans,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'resumption_date' => 'required|date|after:end_date',
            'reason' => 'required|string|max:500',
            'relief_officer_id' => 'required|exists:employees,id',
            'attachment' => 'nullable|mimes:pdf,jpg,png|max:2048', // 2MB Max
        ]);

        $employee = Auth::user()->employee;

        // Calculate Duration excluding weekends (optional logic)
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $duration = $start->diffInDays($end) + 1; 

        // Handle File Upload
        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('leave_attachments', 'public');
        }

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_plan_id' => $request->leave_plan_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration_days' => $duration,
            'resumption_date' => $request->resumption_date,
            'reason' => $request->reason,
            'relief_officer_id' => $request->relief_officer_id,
            'attachment_path' => $path,
            'status' => 'Pending',
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave application submitted successfully!');
    }

    /**
     * HR/Admin Action: Approve Leave
     */
    public function approve(LeaveRequest $leave)
    {
        $leave->update(['status' => 'Approved']);
        
        // Update Employee Status
        $leave->employee->update(['status' => 'On Leave']);

        return back()->with('success', 'Leave has been approved.');
    }

    /**
     * HR/Admin Action: Recall Employee
     */
    public function recall(Request $request, LeaveRequest $leave)
    {
        $request->validate(['reason_for_recall' => 'required']);

        $leave->update([
            'status' => 'Recalled',
            'hr_remarks' => $request->reason_for_recall
        ]);

        $leave->employee->update(['status' => 'Active']);

        return back()->with('info', 'Employee has been recalled to office.');
    }
}