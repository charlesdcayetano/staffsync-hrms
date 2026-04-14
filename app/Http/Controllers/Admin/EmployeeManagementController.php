<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeManagementController extends Controller
{
    /**
     * Display a listing of all employees with filtering.
     */
    public function index(Request $request)
    {
        $query = Employee::with(['user']);

        // Search by name or code
        if ($request->has('search')) {
            $query->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('employee_code', 'like', "%{$request->search}%");
        }

        // Filter by Department
        if ($request->has('department')) {
            $query->where('department_id', $request->department);
        }

        $employees = $query->paginate(15);

        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Store a new employee (Creates both User account and Employee record).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'employee_code' => 'required|unique:employees,employee_code',
            'employment_type' => 'required|in:Full-time,Remote,Shifting,Contract',
            'joining_date' => 'required|date',
        ]);

        // We use a Transaction to ensure both records are created or none at all
        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make('Password123!'), // Default password
            ]);

            $user->employee()->create([
                'employee_code' => $validated['employee_code'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'employment_type' => $validated['employment_type'],
                'joining_date' => $validated['joining_date'],
                'status' => 'Active',
            ]);
        });

        return redirect()->route('admin.employees.index')->with('success', 'New Employee onboarded successfully!');
    }

    /**
     * View detailed profile (HR Perspective).
     */
    public function show(Employee $employee)
    {
        // HR sees everything: Finance, Documents, Family, Education
        $employee->load(['finance', 'education', 'familyMembers', 'documents', 'guarantors']);
        
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Update employee status (e.g., Terminate or suspend).
     */
    public function updateStatus(Request $request, Employee $employee)
    {
        $employee->update(['status' => $request->status]);

        return back()->with('info', "Status updated to {$request->status}");
    }
}