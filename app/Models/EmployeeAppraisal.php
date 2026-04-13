<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeAppraisal extends Model
{
    protected $fillable = [
        'employee_id', 'kpi_goal_id', 'score', 
        'manager_comments', 'appraisal_date'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function kpiGoal()
    {
        return $this->belongsTo(KpiGoal::class);
    }
}