<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveApprovalController extends Controller
{
    public function index()
    {
        // Get pending requests and ongoing leaves for the recall feature
        $pendingLeaves = LeaveRequest::where('status', 'Pending')->with(['employee', 'leavePlan'])->get();
        $ongoingLeaves = LeaveRequest::where('status', 'Approved')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with(['employee', 'reliefOfficer'])
            ->get();

        return view('admin.leaves.index', compact('pendingLeaves', 'ongoingLeaves'));
    }

    public function updateStatus(Request $request, LeaveRequest $leave)
    {
        $request->validate([
            'status' => 'required|in:Approved,Declined',
            'hr_remarks' => 'nullable|string'
        ]);

        $leave->update([
            'status' => $request->status,
            'hr_remarks' => $request->hr_remarks
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => "Leave #{$leave->id} was {$request->status} by HR.",
            'table_affected' => 'leave_requests'
        ]);

        return back()->with('success', "Leave request has been {$request->status}.");
    }

    public function recall(Request $request, LeaveRequest $leave)
    {
        $request->validate(['reason' => 'required|string', 'recall_date' => 'required|date']);

        $leave->update([
            'status' => 'Recalled',
            'end_date' => $request->recall_date,
            'hr_remarks' => "RECALL REASON: " . $request->reason
        ]);

        return back()->with('warning', 'Employee has been officially recalled from leave.');
    }
}