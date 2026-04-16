<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeManagementController extends Controller
{
    public function index(Request $request)
{
    // app/Http/Controllers/Admin/EmployeeManagementController.php

$search = $request->input('search');

$query = Employee::query();

if ($search) {
    $query->where(function ($q) use ($search) {
        $q->where('first_name', 'like', "%{$search}%")
          ->orWhere('last_name', 'like', "%{$search}%")
          ->orWhere('employee_code', 'like', "%{$search}%"); // Fix: Change employee_id to employee_code
    });
}
    $employees = $query->paginate(10);
    return view('admin.employees.index', compact('employees'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'job_title' => 'required|string',
            'joining_date' => 'required|date',
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make('nexus123'), // Default password
        ]);

        $user->employee()->create($validated + ['employee_code' => 'EMP-' . rand(1000, 9999)]);

        return back()->with('success', 'Employee onboarded successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->user->delete(); // Cascades to employee profile
        return back()->with('success', 'Record removed.');
    }
}