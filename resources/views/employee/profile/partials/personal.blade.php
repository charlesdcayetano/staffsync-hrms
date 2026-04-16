<h3 class="text-xl font-black text-gray-900 mb-8 tracking-tight">Personal & Contact Details</h3>
<div class="grid grid-cols-1 md:grid-cols-2 gap-y-10 gap-x-12">
    <div>
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Date of Birth</label>
        <p class="font-bold text-gray-800 mt-1">{{ \Carbon\Carbon::parse($employee->date_of_birth)->format('F d, Y') }}</p>
    </div>
    <div>
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Phone Number</label>
        <p class="font-bold text-gray-800 mt-1">{{ $employee->phone_number }}</p>
    </div>
    <div class="md:col-span-2">
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Residential Address</label>
        <p class="font-bold text-gray-800 mt-1">{{ $employee->address }}</p>
    </div>
</div>