<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class KpiGoal extends Model
{
    protected $fillable = ['title', 'weight', 'description', 'start_date', 'end_date', 'status'];

    public function appraisals()
    {
        return $this->hasMany(EmployeeAppraisal::class);
    }
}