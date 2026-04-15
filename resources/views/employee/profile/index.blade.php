@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto" x-data="{ tab: 'personal' }">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">My Profile</h1>
            <p class="text-gray-500 mt-1">Manage your professional and personal information.</p>
        </div>
        <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-3 h-3 rounded-full bg-green-400 animate-pulse"></div>
            <span class="text-sm font-semibold text-gray-700">{{ $employee->status }}</span>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex overflow-x-auto bg-gray-50/50 border-b border-gray-100 px-4">
            @foreach(['personal' => 'Personal Info', 'education' => 'Education', 'financial' => 'Financial Details', 'documents' => 'Documents'] as $key => $label)
                <button 
                    @click="tab = '{{ $key }}'" 
                    :class="tab === '{{ $key }}' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-400 hover:text-gray-600'" 
                    class="px-6 py-5 text-sm font-bold border-b-2 transition-all duration-200 whitespace-nowrap">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="p-8 lg:p-12">
            
            <div x-show="tab === 'personal'" x-transition.opacity>
                <div class="flex flex-col md:flex-row items-center gap-8 mb-12 pb-12 border-b border-gray-50">
                    <form action="{{ route('profile.updatePersonal') }}" method="POST" enctype="multipart/form-data" class="relative group">
                        @csrf
                        <div class="relative">
                            <img src="{{ $employee->profile_photo ? asset('storage/' . $employee->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($employee->first_name).'&background=f3f4f6&color=a1a1aa' }}" 
                                 class="w-32 h-32 rounded-[2.5rem] object-cover border-4 border-white shadow-md ring-1 ring-gray-100">
                            
                            <label class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-[2.5rem] opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity duration-300">
                                <input type="file" name="profile_photo" class="hidden" onchange="this.form.submit()">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </label>
                        </div>
                    </form>
                    
                    <div class="text-center md:text-left">
                        <h2 class="text-2xl font-black text-gray-900 tracking-tight">{{ $employee->first_name }} {{ $employee->last_name }}</h2>
                        <p class="text-gray-400 font-bold uppercase text-xs tracking-widest mt-1">{{ $employee->job_title }}</p>
                        <p class="text-sm text-gray-500 mt-2 italic">Click the photo to upload a new profile picture.</p>
                    </div>
                </div>

                <form action="{{ route('profile.updatePersonal') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest">Full Name</label>
                            <input type="text" value="{{ $employee->first_name }} {{ $employee->last_name }}" disabled class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-500 font-medium cursor-not-allowed">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest">Employee Code</label>
                            <input type="text" value="{{ $employee->employee_code }}" disabled class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-500 font-mono cursor-not-allowed">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest">Contact Number</label>
                            <input type="text" name="phone_number" value="{{ $employee->phone_number }}" class="w-full bg-white border border-gray-100 rounded-2xl p-4 shadow-sm focus:ring-4 focus:ring-gray-100 transition outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest">City of Residence</label>
                            <input type="text" name="city_of_residence" value="{{ $employee->city_of_residence }}" class="w-full bg-white border border-gray-100 rounded-2xl p-4 shadow-sm focus:ring-4 focus:ring-gray-100 transition outline-none">
                        </div>
                    </div>
                    
                    <div class="mt-10 flex items-center justify-between">
                        <button type="submit" class="bg-gray-900 text-white px-10 py-4 rounded-2xl font-bold hover:bg-black transition shadow-xl shadow-gray-200 active:scale-95">
                            Save Changes
                        </button>
                        
                        @if(auth()->user()->is_admin)
                        <span class="text-xs font-bold text-amber-500 bg-amber-50 px-4 py-2 rounded-lg">HR Editing Mode Active</span>
                        @endif
                    </div>
                </form>
            </div>

            <div x-show="tab === 'education'" x-cloak x-transition.opacity>
                <div class="space-y-6">
                    @forelse($employee->education as $edu)
                    <div class="flex items-start gap-6 p-6 rounded-3xl bg-gray-50 border border-gray-100">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-xl shadow-sm">🎓</div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg">{{ $edu->institution_name }}</h4>
                            <p class="text-gray-500 font-medium">{{ $edu->course_study }} ({{ $edu->qualification_type }})</p>
                            <p class="text-xs text-gray-400 mt-1 uppercase font-bold tracking-tighter">{{ $edu->start_date }} — {{ $edu->end_date ?? 'Present' }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-400 italic">No education history recorded.</p>
                    @endforelse
                </div>
            </div>

            <div x-show="tab === 'financial'" x-cloak x-transition.opacity>
                <div class="max-w-md">
                    <div class="p-8 rounded-3xl bg-gradient-to-br from-gray-900 to-gray-800 text-white shadow-2xl mb-8 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full"></div>
                        <p class="text-xs font-bold opacity-50 uppercase mb-6 tracking-widest">Salary Disbursement Account</p>
                        <p class="text-2xl font-mono tracking-widest mb-8">{{ $employee->finance->account_number ?? '**** **** ****' }}</p>
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[10px] uppercase opacity-50">Bank Name</p>
                                <p class="font-bold tracking-tight">{{ $employee->finance->bank_name ?? 'NOT LINKED' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] uppercase opacity-50">Account Holder</p>
                                <p class="font-bold">{{ $employee->finance->account_name ?? $employee->first_name }}</p>
                            </div>
                        </div>
                    </div>
                    <button class="text-sm font-bold text-gray-400 hover:text-gray-900 transition flex items-center gap-2">
                        <span>Modify Bank Details</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </button>
                </div>
            </div>

            <div x-show="tab === 'documents'" x-cloak x-transition.opacity>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($employee->documents as $doc)
                    <div class="group p-6 border border-gray-100 rounded-3xl hover:bg-gray-50 hover:border-gray-200 transition-all flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center group-hover:bg-white transition">📄</div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $doc->document_type }}</p>
                                <p class="text-xs text-gray-400">{{ $doc->file_name }}</p>
                            </div>
                        </div>
                        <a href="{{ Storage::url($doc->file_path) }}" download class="bg-white border border-gray-100 p-3 rounded-xl hover:shadow-md transition">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </a>
                    </div>
                    @empty
                    <p class="text-gray-400 italic">No documents uploaded.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection