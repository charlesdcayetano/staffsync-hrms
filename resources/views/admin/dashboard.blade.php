@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Overview</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        @foreach($stats as $key => $value)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ str_replace('_', ' ', $key) }}</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $value }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-50 font-bold">Recent Leave Requests</div>
            <div class="p-6">
                @foreach($recentLeaves as $leave)
                <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $leave->employee->first_name }}</p>
                        <p class="text-xs text-gray-400">{{ $leave->leavePlan->plan_name }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-50 text-yellow-600">{{ $leave->status }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold mb-6">🎂 Upcoming Birthdays</h3>
            <div class="space-y-4">
                @foreach($birthdays as $bday)
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center">🎁</div>
                    <div>
                        <p class="text-sm font-bold">{{ $bday->first_name }} {{ $bday->last_name }}</p>
                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($bday->date_of_birth)->format('M d') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection