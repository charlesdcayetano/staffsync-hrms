<h3 class="text-xl font-black text-gray-900 mb-8 tracking-tight">Job & Financial Details</h3>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="p-8 bg-gray-900 rounded-[2.5rem] text-white">
        <p class="text-[10px] font-black opacity-50 uppercase tracking-[0.2em]">Monthly Basic Salary</p>
        <p class="text-4xl font-black mt-2 tracking-tighter">₱{{ number_format($employee->financialDetails->basic_salary ?? 0, 0) }}</p>
    </div>
    <div class="p-8 bg-gray-50 rounded-[2.5rem] border border-gray-100">
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Bank Details</p>
        <p class="text-xl font-bold text-gray-900 mt-2">{{ $employee->financialDetails->bank_name ?? 'Not Set' }}</p>
        <p class="text-sm font-bold text-gray-400 mt-1">{{ $employee->financialDetails->account_number ?? '---' }}</p>
    </div>
</div>