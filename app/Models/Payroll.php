<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id', 'pay_period_start', 'pay_period_end', 
        'basic_salary', 'net_pay', 'status'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // This handles the specific tax, loans, and deductions
    public function breakdowns(): HasMany
    {
        return $this->hasMany(PayrollBreakdown::class);
    }
}