<div class="bg-white rounded-[2.5rem] border border-gray-50 overflow-hidden shadow-sm">
    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center">
        <h3 class="font-black text-sm uppercase tracking-widest text-gray-900">My Leave History</h3>
    </div>
    
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50/50">
            <tr>
                <th class="px-10 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Type</th>
                <th class="px-10 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Date Range</th>
                <th class="px-10 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaves as $leave)
            <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/30 transition">
                <td class="px-10 py-6">
                    <p class="text-sm font-bold text-gray-900">{{ $leave->leavePlan->plan_name }}</p>
                </td>
                <td class="px-10 py-6">
                    <p class="text-xs font-bold text-gray-500">{{ $leave->start_date }} - {{ $leave->end_date }}</p>
                </td>
                <td class="px-10 py-6">
                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase
                        {{ $leave->status == 'Approved' ? 'bg-green-50 text-green-500' : 'bg-amber-50 text-amber-500' }}">
                        {{ $leave->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>