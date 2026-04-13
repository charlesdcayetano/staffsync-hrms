<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollBreakdown extends Model
{
    protected $fillable = ['payroll_id', 'type', 'item_name', 'amount'];

    // Types: 'allowance', 'deduction', 'tax', 'loan_repayment'
}