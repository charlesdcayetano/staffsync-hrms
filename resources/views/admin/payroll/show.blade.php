@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto py-10 print:py-0">
    <div class="mb-6 flex justify-between items-center print:hidden">
        <a href="{{ route('admin.payroll.index') }}" class="text-sm font-bold text-gray-400">← Back</a>
        <button onclick="window.print()" class="bg-gray-100 px-4 py-2 rounded-xl text-xs font-black uppercase">Print PDF</button>
    </div>

    <div class="bg-white p-12 rounded-[2rem] shadow-sm border border-gray-100 print:shadow-none print:border-none">
        <div class="flex justify-between items-start mb-12">
            <div>
                <h1 class="text-2xl font-black tracking-tighter">Nexus<span class="text-gray-400">HR</span></h1>
                <p class="text-xs text-gray-400 uppercase font-bold">Bailan District Hospital</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold">PAYSLIP #{{ str_pad($payroll->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p class="text-xs text-gray-400">Period: {{ \Carbon\Carbon::parse($payroll->pay_period_start)->format('F Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-12 py-6 border-y border-gray-50">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase">Employee</p>
                <p class="font-bold text-gray-900">{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</p>
                <p class="text-xs text-gray-500">{{ $payroll->employee->job_title }}</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black text-gray-400 uppercase">Employee ID</p>
                <p class="font-bold text-gray-900">{{ $payroll->employee->employee_code }}</p>
            </div>
        </div>

        <div class="space-y-4 mb-12">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Basic Salary</span>
                <span class="font-mono font-bold text-gray-900">₱{{ number_format($payroll->basic_salary, 2) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500 text-red-400 font-medium">Total Deductions</span>
                <span class="font-mono font-bold text-red-400">- ₱{{ number_format($payroll->total_deductions, 2) }}</span>
            </div>
        </div>

        <div class="bg-gray-900 rounded-3xl p-8 text-white flex justify-between items-center">
            <div>
                <p class="text-[10px] font-black opacity-50 uppercase tracking-widest">Net Take Home Pay</p>
                <p class="text-3xl font-bold tracking-tighter mt-1">₱ {{ number_format($payroll->net_pay, 2) }}</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black opacity-50 uppercase tracking-widest">Status</p>
                <p class="font-bold">DISBURSED</p>
            </div>
        </div>
    </div>
</div>
@endsection