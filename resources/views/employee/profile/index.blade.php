@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto" x-data="{ tab: 'personal' }">
    
    <div class="bg-white rounded-[2.5rem] p-8 border border-gray-50 shadow-sm mb-8 flex flex-col md:flex-row items-center gap-8">
        <div class="relative group">
            <img src="{{ $employee->profile_photo ? asset('storage/' . $employee->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($employee->first_name).'&background=f3f4f6&color=111827' }}" 
                 class="w-32 h-32 rounded-[2.5rem] object-cover border-4 border-gray-50 shadow-lg group-hover:opacity-90 transition">
        </div>
        <div class="text-center md:text-left">
            <h1 class="text-3xl font-black text-gray-900 tracking-tighter">{{ $employee->first_name }} {{ $employee->last_name }}</h1>
            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-[0.2em] mt-1">{{ $employee->department }} • {{ $employee->designation }}</p>
            <div class="flex gap-2 mt-4 justify-center md:justify-start">
                <span class="px-4 py-1.5 bg-gray-900 text-white text-[10px] font-black uppercase rounded-xl">Personnel ID: {{ $employee->employee_id }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-1 space-y-2">
            @php
                $tabs = [
                    'personal' => 'Personal & Contact',
                    'academic' => 'Academic & Education',
                    'family' => 'Family & Next of Kin',
                    'job' => 'Job & Financials',
                    'guarantor' => 'Guarantor Details'
                ];
            @endphp
            @foreach($tabs as $id => $label)
            <button @click="tab = '{{ $id }}'" 
                :class="tab === '{{ $id }}' ? 'bg-gray-900 text-white shadow-xl' : 'bg-white text-gray-500 hover:bg-gray-50'"
                class="w-full text-left px-6 py-4 rounded-2xl font-bold text-sm transition-all duration-300 flex justify-between items-center group">
                {{ $label }}
                <svg :class="tab === '{{ $id }}' ? 'translate-x-0 opacity-100' : '-translate-x-2 opacity-0'" class="w-4 h-4 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"/></svg>
            </button>
            @endforeach
        </div>

        <div class="lg:col-span-3">
            <div class="bg-white rounded-[2.5rem] border border-gray-50 shadow-sm min-h-[500px] p-10">
                <div x-show="tab === 'personal'" x-transition> @include('employee.profile.partials.personal') </div>
                <div x-show="tab === 'academic'" x-transition> @include('employee.profile.partials.academic') </div>
                <div x-show="tab === 'family'" x-transition> @include('employee.profile.partials.family') </div>
                <div x-show="tab === 'job'" x-transition> @include('employee.profile.partials.job') </div>
                <div x-show="tab === 'guarantor'" x-transition> @include('employee.profile.partials.guarantor') </div>
            </div>
        </div>
    </div>
</div>
@endsection