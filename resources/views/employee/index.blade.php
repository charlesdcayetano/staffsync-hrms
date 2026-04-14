@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto" x-data="{ tab: 'personal' }">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex bg-gray-50 border-b border-gray-100">
            <button @click="tab = 'personal'" :class="tab === 'personal' ? 'bg-white border-b-2 border-gray-900 text-gray-900' : 'text-gray-400'" class="px-8 py-4 text-sm font-bold transition">Personal Info</button>
            <button @click="tab = 'finance'" :class="tab === 'finance' ? 'bg-white border-b-2 border-gray-900 text-gray-900' : 'text-gray-400'" class="px-8 py-4 text-sm font-bold transition">Financial</button>
            <button @click="tab = 'docs'" :class="tab === 'docs' ? 'bg-white border-b-2 border-gray-900 text-gray-900' : 'text-gray-400'" class="px-8 py-4 text-sm font-bold transition">Documents</button>
        </div>

        <div class="p-8">
            <div x-show="tab === 'personal'" class="space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Full Name</label>
                        <p class="text-lg font-semibold">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Employee ID</label>
                        <p class="text-lg font-semibold">{{ $employee->employee_code }}</p>
                    </div>
                </div>
            </div>

            <div x-show="tab === 'finance'" class="space-y-6" x-cloak>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-1">Bank Account</p>
                    <p class="font-mono text-lg">{{ $employee->finance->account_number ?? 'Not Set' }}</p>
                </div>
            </div>

            <div x-show="tab === 'docs'" class="space-y-4" x-cloak>
                @foreach($employee->documents as $doc)
                <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition">
                    <span class="font-medium text-gray-700">{{ $doc->document_type }}</span>
                    <a href="#" class="text-sm font-bold text-gray-900 underline">Download</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection