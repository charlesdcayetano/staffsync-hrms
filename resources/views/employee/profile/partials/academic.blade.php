<h3 class="text-xl font-black text-gray-900 mb-8 tracking-tight">Education & Qualifications</h3>
<div class="space-y-6">
    @foreach($employee->educationQualifications as $edu)
    <div class="p-6 bg-gray-50 rounded-3xl border border-gray-100 flex justify-between items-center">
        <div>
            <p class="font-black text-gray-900">{{ $edu->qualification_name }}</p>
            <p class="text-xs font-bold text-gray-400 uppercase">{{ $edu->institution }} • {{ $edu->year_attained }}</p>
        </div>
        <span class="px-3 py-1 bg-white border border-gray-200 rounded-lg text-[10px] font-black uppercase">Verified</span>
    </div>
    @endforeach
</div>