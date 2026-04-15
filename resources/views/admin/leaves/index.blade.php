@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto" x-data="{ recallModal: false, selectedLeave: null }">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Leave Management</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700">Pending Requests</h3>
                    <span class="bg-gray-100 text-gray-500 text-xs font-black px-2 py-1 rounded-md">{{ $pendingLeaves->count() }}</span>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($pendingLeaves as $leave)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center text-xl">📄</div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</p>
                                    <p class="text-xs text-gray-400 uppercase font-bold">{{ $leave->leavePlan->plan_name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($leave->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('M d') }}</p>
                                <p class="text-xs text-gray-400">{{ $leave->total_days }} Days Total</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.leaves.updateStatus', $leave) }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="hr_remarks" placeholder="Add remarks..." class="flex-1 bg-gray-50 border-none rounded-xl px-4 text-sm">
                            <button name="status" value="Approved" class="bg-gray-900 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-black transition">Approve</button>
                            <button name="status" value="Declined" class="bg-white border border-gray-200 text-gray-400 px-4 py-2 rounded-xl text-sm font-bold hover:text-red-500 transition">Decline</button>
                        </form>
                    </div>
                    @empty
                    <div class="p-12 text-center text-gray-400 italic">No pending requests.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-6">In-Field Staff (Ongoing)</h3>
                <div class="space-y-4">
                    @forelse($ongoingLeaves as $on)
                    <div class="group p-4 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-md border border-transparent hover:border-gray-100 transition-all">
                        <p class="font-bold text-gray-800 text-sm">{{ $on->employee->first_name }}</p>
                        <p class="text-xs text-gray-400 mb-3">Relief: {{ $on->reliefOfficer->first_name ?? 'None' }}</p>
                        <button @click="recallModal = true; selectedLeave = {{ $on->id }}" class="w-full py-2 text-[10px] font-black uppercase tracking-widest text-red-400 border border-red-100 rounded-lg group-hover:bg-red-50 transition">
                            Recall to Office
                        </button>
                    </div>
                    @empty
                    <p class="text-gray-400 text-xs italic text-center py-4">No staff currently on leave.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div x-show="recallModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/10 backdrop-blur-sm p-4">
        <div @click.outside="recallModal = false" class="bg-white rounded-[2.5rem] p-10 w-full max-w-md shadow-2xl border border-white">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Emergency Recall</h2>
            <p class="text-sm text-gray-500 mb-8">Shorten the leave period and notify the employee immediately.</p>
            
            <form :action="'/admin/leaves/' + selectedLeave + '/recall'" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase">New End Date</label>
                    <input type="date" name="recall_date" value="{{ date('Y-m-d') }}" class="w-full bg-gray-50 border-none rounded-xl p-4 shadow-inner">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase">Reason for Recall</label>
                    <textarea name="reason" rows="3" class="w-full bg-gray-50 border-none rounded-xl p-4" placeholder="Urgent project requirements..."></textarea>
                </div>
                <button class="w-full bg-red-500 text-white py-4 rounded-2xl font-bold shadow-lg shadow-red-100 hover:bg-red-600 transition">Confirm Recall</button>
            </form>
        </div>
    </div>
</div>
@endsection