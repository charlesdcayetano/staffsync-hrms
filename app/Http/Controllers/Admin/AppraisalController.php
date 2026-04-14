<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KpiGoal;
use App\Models\EmployeeAppraisal;
use App\Models\Employee;
use Illuminate\Http\Request;

class AppraisalController extends Controller
{
    /**
     * View all KPI Goals and recent Appraisals.
     */
    public function index()
    {
        $goals = KpiGoal::latest()->get();
        $appraisals = EmployeeAppraisal::with(['employee', 'kpiGoal'])->latest()->paginate(10);
        
        return view('admin.performance.index', compact('goals', 'appraisals'));
    }

    /**
     * Create a new KPI Goal (Target Setup).
     */
    public function storeGoal(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'weight' => 'required|numeric|min:1|max:100', // e.g., 20% of total score
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        KpiGoal::create($validated + ['status' => 'Initiated']);

        return back()->with('success', 'KPI Goal has been set up and initiated.');
    }

    /**
     * Initiate an Appraisal for a specific employee.
     */
    public function storeAppraisal(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'kpi_goal_id' => 'required|exists:kpi_goals,id',
            'score' => 'required|numeric|min:0|max:100',
            'manager_comments' => 'nullable|string',
        ]);

        EmployeeAppraisal::create([
            'employee_id' => $request->employee_id,
            'kpi_goal_id' => $request->kpi_goal_id,
            'score' => $request->score,
            'manager_comments' => $request->manager_comments,
            'appraisal_date' => now(),
        ]);

        return back()->with('success', 'Employee appraisal submitted successfully.');
    }
}