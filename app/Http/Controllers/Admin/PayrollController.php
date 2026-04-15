<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee')->latest()->paginate(10);
        return view('admin.payroll.index', compact('payrolls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required',
            'basic_salary' => 'required|numeric',
            'allowances' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
        ]);

        $net_pay = ($request->basic_salary + ($request->allowances ?? 0)) - ($request->deductions ?? 0);

        Payroll::create([
            'employee_id' => $request->employee_id,
            'pay_period_start' => $request->month . '-01',
            'pay_period_end' => date("Y-m-t", strtotime($request->month . '-01')),
            'basic_salary' => $request->basic_salary,
            'total_deductions' => $request->deductions ?? 0,
            'net_pay' => $net_pay,
            'status' => 'Generated'
        ]);

        return back()->with('success', 'Payslip generated successfully.');
    }

    public function show(Payroll $payroll)
    {
        return view('admin.payroll.show', compact('payroll'));
    }
}