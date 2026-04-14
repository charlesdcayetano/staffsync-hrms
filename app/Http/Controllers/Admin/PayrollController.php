<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollBreakdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * List all payroll records.
     */
    public function index()
    {
        $payrolls = Payroll::with('employee')->latest()->paginate(15);
        return view('admin.payroll.index', compact('payrolls'));
    }

    /**
     * Generate Payroll for an employee.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'pay_period_start' => 'required|date',
            'pay_period_end' => 'required|date',
            'basic_salary' => 'required|numeric',
            // Arrays for dynamic breakdowns
            'allowances.*.name' => 'nullable|string',
            'allowances.*.amount' => 'nullable|numeric',
            'deductions.*.name' => 'nullable|string',
            'deductions.*.amount' => 'nullable|numeric',
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Calculate Totals
            $totalAllowances = collect($request->allowances)->sum('amount');
            $totalDeductions = collect($request->deductions)->sum('amount');
            
            // Simple Tax logic (e.g., 10% of basic) - you can make this dynamic
            $tax = $request->basic_salary * 0.10; 
            
            $netPay = ($request->basic_salary + $totalAllowances) - ($totalDeductions + $tax);

            // 2. Create Main Payroll Record
            $payroll = Payroll::create([
                'employee_id' => $request->employee_id,
                'pay_period_start' => $request->pay_period_start,
                'pay_period_end' => $request->pay_period_end,
                'basic_salary' => $request->basic_salary,
                'net_pay' => $netPay,
                'status' => 'Paid'
            ]);

            // 3. Save Breakdowns (Allowances)
            foreach ($request->allowances as $item) {
                if ($item['amount'] > 0) {
                    $payroll->breakdowns()->create([
                        'type' => 'allowance',
                        'item_name' => $item['name'],
                        'amount' => $item['amount']
                    ]);
                }
            }

            // 4. Save Breakdowns (Tax & Deductions)
            $payroll->breakdowns()->create([
                'type' => 'tax',
                'item_name' => 'Income Tax',
                'amount' => $tax
            ]);

            foreach ($request->deductions as $item) {
                if ($item['amount'] > 0) {
                    $payroll->breakdowns()->create([
                        'type' => 'deduction',
                        'item_name' => $item['name'],
                        'amount' => $item['amount']
                    ]);
                }
            }

            return redirect()->route('admin.payroll.index')->with('success', 'Payroll generated and breakdowns recorded.');
        });
    }

    /**
     * View a specific payslip (for Admin or User).
     */
    public function show(Payroll $payroll)
    {
        $payroll->load(['employee', 'breakdowns']);
        return view('admin.payroll.show', compact('payroll'));
    }
}