<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeFinance extends Model
{
    protected $fillable = [
        'employee_id',
        'bank_name',
        'account_number',
        'account_name',
        'tax_id_number'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}