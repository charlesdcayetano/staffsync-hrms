<h3 class="text-xl font-black text-gray-900 mb-6 tracking-tight">Family Members</h3>
<div class="grid grid-cols-1 gap-4 mb-10">
    @foreach($employee->familyMembers as $member)
    <div class="flex items-center justify-between p-5 bg-white border border-gray-100 rounded-2xl shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center font-bold text-gray-400 text-xs">FM</div>
            <div>
                <p class="font-bold text-gray-900">{{ $member->name }}</p>
                <p class="text-[10px] font-black text-gray-400 uppercase">{{ $member->relationship }}</p>
            </div>
        </div>
        <p class="text-sm font-bold text-gray-700">{{ $member->contact_number }}</p>
    </div>
    @endforeach
</div>

<h3 class="text-xl font-black text-gray-900 mb-6 tracking-tight">Next of Kin</h3>
<div class="p-8 bg-amber-50 rounded-[2rem] border border-amber-100">
    <div class="flex justify-between items-start">
        <div>
            <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Primary Emergency Contact</p>
            <p class="text-lg font-black text-gray-900 mt-1">{{ $employee->nextOfKin->name ?? 'None' }}</p>
            <p class="text-sm font-bold text-gray-500 mt-1">{{ $employee->nextOfKin->relation ?? '' }} • {{ $employee->nextOfKin->phone ?? '' }}</p>
        </div>
    </div>
</div>