<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leave_plan_id',
        'start_date',
        'end_date',
        'duration_days',
        'resumption_date',
        'reason',
        'relief_officer_id',
        'status',
        'attachment_path',
        'hr_remarks'
    ];

    // The employee who is applying
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // The type of leave (Annual, Sick, etc.)
    public function leavePlan()
    {
        return $this->belongsTo(LeavePlan::class);
    }

    // The colleague covering the duties
    public function reliefOfficer()
    {
        return $this->belongsTo(Employee::class, 'relief_officer_id');
    }
}