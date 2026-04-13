<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\EmployeeEducation;
use App\Models\EmployeeFamily;
use App\Models\EmployeeFinance;
use App\Models\EmployeeGuarantor;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_code',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'marital_status',
        'employment_type',
        'department_id',
        'job_id',
        'joining_date',
        'status',
    ];

    /**
     * Link to the User account for login.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * LEAVE MANAGEMENT RELATIONSHIPS
     */

    // Leaves applied for by this employee
    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    // Leaves where this employee is covering for someone else
    public function reliefDuties(): HasMany
    {
        return $this->hasMany(LeaveRequest::class, 'relief_officer_id');
    }

    /**
     * PROFILE SECTIONS (Next of Kin, Education, etc.)
     */

    // Financial Details (Bank name, Account no)
    public function finance(): HasOne
    {
        return $this->hasOne(EmployeeFinance::class);
    }

    // Education Records (Degrees, Institutions)
    public function education(): HasMany
    {
        return $this->hasMany(EmployeeEducation::class);
    }

    // Family & Next of Kin
    public function familyMembers(): HasMany
    {
        return $this->hasMany(EmployeeFamily::class);
    }

    // Guarantors
    public function guarantors(): HasMany
    {
        return $this->hasMany(EmployeeGuarantor::class);
    }

    // Uploaded Documents (Birth Cert, Degree, etc.)
    public function documents(): HasMany
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    /**
     * PAYROLL & PERFORMANCE
     */

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    public function appraisals(): HasMany
    {
        return $this->hasMany(EmployeeAppraisal::class);
    }

    /**
     * HELPER METHODS
     */

    // Get Full Name
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Check if employee is currently on leave
    public function isOnLeave(): bool
    {
        return $this->status === 'On Leave';
    }
}