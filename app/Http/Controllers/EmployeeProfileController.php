<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeEducation;
use App\Models\EmployeeFamily;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeProfileController extends Controller
{
    /**
     * Display the authenticated user's profile tabs.
     */
    public function index()
{
    // Type-hinting the user helps the IDE understand what $user is
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Use the property directly or load the relation
    $employee = $user->employee()->with([
        'finance', 
        'education', 
        'familyMembers', 
        'guarantors', 
        'documents'
    ])->firstOrFail();

    return view('employee.profile.index', compact('employee'));
}

    /**
     * Update Personal & Contact Details.
     */
    public function updatePersonal(Request $request)
    {
        $employee = Auth::user()->employee;

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone_number' => 'required|string',
            'residential_address' => 'required|string',
            'city_of_residence' => 'required|string',
        ]);

        $employee->update($validated);

        return back()->with('success', 'Personal details updated successfully!');
    }

    /**
     * Handle Document Uploads (Office Letter, Birth Cert, etc.)
     */
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,png,docx|max:5120', // 5MB Limit
        ]);

        $employee = Auth::user()->employee;

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('employee_docs/' . $employee->employee_code, 'public');

            $employee->documents()->create([
                'document_type' => $request->document_type,
                'file_path' => $path,
                'file_name' => $request->file('file')->getClientOriginalName(),
            ]);
        }

        return back()->with('success', 'Document uploaded successfully!');
    }

    /**
     * Update Financial/Bank Details.
     */
    public function updateFinance(Request $request)
    {
        $employee = Auth::user()->employee;

        $validated = $request->validate([
            'bank_name' => 'required|string',
            'account_number' => 'required|numeric',
            'account_name' => 'required|string',
        ]);

        $employee->finance()->updateOrCreate(
            ['employee_id' => $employee->id],
            $validated
        );

        return back()->with('success', 'Financial details updated!');
    }
}