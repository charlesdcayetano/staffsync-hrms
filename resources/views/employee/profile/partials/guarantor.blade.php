<h3 class="text-xl font-black text-gray-900 mb-8 tracking-tight">Guarantor Information</h3>
<div class="space-y-4">
    @foreach($employee->guarantors as $guarantor)
    <div class="p-6 border border-gray-100 rounded-[2rem] hover:bg-gray-50 transition">
        <div class="flex justify-between">
            <p class="font-black text-gray-900">{{ $guarantor->name }}</p>
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $guarantor->relationship }}</span>
        </div>
        <div class="mt-4 flex gap-6">
            <div>
                <label class="text-[9px] font-black text-gray-400 uppercase">Phone</label>
                <p class="text-xs font-bold">{{ $guarantor->phone }}</p>
            </div>
            <div>
                <label class="text-[9px] font-black text-gray-400 uppercase">Employer</label>
                <p class="text-xs font-bold text-gray-600">{{ $guarantor->employer }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>