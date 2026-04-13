<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeavePlan extends Model
{
    protected $fillable = [
        'plan_name',
        'total_duration_days',
        'is_recallable',
        'has_bonus',
        'bonus_percentage',
        'is_active'
    ];

    public function requests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}