@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto" x-data="{ showGen: false }">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Payroll Management</h1>
        <button @click="showGen = true" class="bg-gray-900 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-black transition shadow-lg shadow-gray-200">
            Generate New Payslip
        </button>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                    <th class="p-6">Employee</th>
                    <th class="p-6">Period</th>
                    <th class="p-6">Net Pay</th>
                    <th class="p-6">Status</th>
                    <th class="p-6 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($payrolls as $pay)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="p-6 font-bold text-gray-800">{{ $pay->employee->first_name }}</td>
                    <td class="p-6 text-sm text-gray-500">{{ \Carbon\Carbon::parse($pay->pay_period_start)->format('M Y') }}</td>
                    <td class="p-6 font-mono font-bold text-gray-900">₱{{ number_format($pay->net_pay, 2) }}</td>
                    <td class="p-6"><span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black uppercase rounded-full">Paid</span></td>
                    <td class="p-6 text-right">
                        <a href="{{ route('admin.payroll.show', $pay) }}" class="text-gray-900 font-bold text-xs underline">View Slip</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div x-show="showGen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/10 backdrop-blur-md p-4">
        <div @click.outside="showGen = false" class="bg-white rounded-[2.5rem] p-10 w-full max-w-lg shadow-2xl">
            <h2 class="text-2xl font-bold mb-6">Quick Generate</h2>
            <form action="{{ route('admin.payroll.store') }}" method="POST" class="space-y-4">
                @csrf
                <select name="employee_id" class="w-full bg-gray-50 border-none rounded-2xl p-4">
                    @foreach(\App\Models\Employee::all() as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }}</option>
                    @endforeach
                </select>
                <input type="month" name="month" class="w-full bg-gray-50 border-none rounded-2xl p-4" value="{{ date('Y-m') }}">
                <input type="number" name="basic_salary" placeholder="Basic Salary (₱)" class="w-full bg-gray-50 border-none rounded-2xl p-4">
                <div class="grid grid-cols-2 gap-4">
                    <input type="number" name="allowances" placeholder="Allowances" class="bg-gray-50 border-none rounded-2xl p-4">
                    <input type="number" name="deductions" placeholder="Total Deductions" class="bg-gray-50 border-none rounded-2xl p-4">
                </div>
                <button class="w-full bg-gray-900 text-white py-4 rounded-2xl font-bold mt-4 shadow-xl shadow-gray-200">Calculate & Save</button>
            </form>
        </div>
    </div>
</div>
@endsection