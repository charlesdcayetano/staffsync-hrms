<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveApprovalController extends Controller
{
    /**
     * Show all pending and ongoing leaves for HR.
     */
    public function index()
    {
        $pendingLeaves = LeaveRequest::where('status', 'Pending')->with(['employee', 'leavePlan'])->get();
        $ongoingLeaves = LeaveRequest::where('status', 'Approved')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with(['employee', 'reliefOfficer'])
            ->get();

        return view('admin.leaves.manage', compact('pendingLeaves', 'ongoingLeaves'));
    }

    /**
     * Approve or Decline a Leave Request.
     */
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
        
        $leave->employee->user->notify(new \App\Notifications\LeaveStatusUpdated($leave));

        // Audit Trail
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => "Changed Leave #{$leave->id} status to {$request->status}",
            'table_affected' => 'leave_requests'
        ]);

        return back()->with('success', "Leave request has been {$request->status}.");
    }

    /**
     * Recall an Employee (For ongoing leaves).
     */
    public function recall(Request $request, LeaveRequest $leave)
    {
        $request->validate([
            'reason_for_recall' => 'required|string',
            'recall_date' => 'required|date'
        ]);

        // Logic: Calculate remaining days
        $remainingDays = now()->diffInDays($leave->end_date);

        $leave->update([
            'status' => 'Recalled',
            'hr_remarks' => "RECALL: " . $request->reason_for_recall,
            'end_date' => $request->recall_date // Shorten the leave to today
        ]);

        // Audit Trail
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => "Recalled Employee from Leave #{$leave->id}. Days lost: {$remainingDays}",
            'table_affected' => 'leave_requests'
        ]);

        return back()->with('warning', 'Employee has been officially recalled.');
    }
}