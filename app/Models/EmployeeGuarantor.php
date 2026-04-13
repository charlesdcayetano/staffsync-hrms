<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeGuarantor extends Model
{
    protected $fillable = [
        'employee_id',
        'guarantor_name',
        'job_title',
        'phone_number',
        'address',
        'is_internal_staff', // Boolean to check if they work in the company
        'internal_staff_id'  // Foreign key to the employees table if true
    ];

    /**
     * Relationship: The employee this guarantor is vouching for.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Relationship: If the guarantor is an internal staff member.
     */
    public function internalStaff(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'internal_staff_id');
    }
}