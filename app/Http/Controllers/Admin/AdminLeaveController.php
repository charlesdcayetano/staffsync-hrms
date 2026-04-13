<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class AdminLeaveController extends Controller
{
    // HR approves the leave
    public function approve(LeaveRequest $leave)
    {
        $leave->update(['status' => 'Approved']);
        return back()->with('success', 'Leave request approved.');
    }

    // HR Recalls an employee from an ongoing leave
    public function recall(Request $request, LeaveRequest $leave)
    {
        $leave->update([
            'status' => 'Recalled',
            'reason_for_recall' => $request->reason // This maps to your requirement
        ]);
        
        // Logic to notify the employee would go here
        return back()->with('warning', 'Employee has been recalled to work.');
    }
}