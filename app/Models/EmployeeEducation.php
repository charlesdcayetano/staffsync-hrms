<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeEducation extends Model
{
    protected $table = 'employee_educations'; // Explicit table name

    protected $fillable = [
        'employee_id',
        'institution_name',
        'course_study',
        'qualification_type',
        'start_date',
        'end_date',
        'description'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}