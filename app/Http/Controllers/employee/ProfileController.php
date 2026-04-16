<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Fetching all modules tied to the authenticated user's employee record
        $employee = Auth::user()->employee->load([
            'familyMembers', 
            'educationQualifications', 
            'academicInfo',
            'guarantors',
            'nextOfKin',
            'jobDetails',
            'financialDetails'
            
        ]);

        return view('employee.profile.index', compact('employee'));
    }
}