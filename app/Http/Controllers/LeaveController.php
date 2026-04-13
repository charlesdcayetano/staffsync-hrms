<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveController extends Controller {
    public function approve($id) {
        $leave = LeaveRequest::findOrFail($id);
        $leave->update(['status' => 'Approved']);
        
        // Logic to notify employee and update audit trail
        return back()->with('success', 'Leave approved successfully.');
    }

    public function recall(Request $request, $id) {
        $leave = LeaveRequest::findOrFail($id);
        $leave->update([
            'status' => 'Recalled',
            'hr_remarks' => $request->reason_for_recall
        ]);
        return back()->with('info', 'Employee has been recalled.');
    }
}