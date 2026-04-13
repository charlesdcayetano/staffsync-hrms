<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeFamily extends Model
{
    protected $fillable = [
        'employee_id',
        'full_name',
        'relationship',
        'occupation',
        'phone_number',
        'address',
        'is_next_of_kin',
        'is_emergency_contact'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}