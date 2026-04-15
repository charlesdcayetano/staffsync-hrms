@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto" x-data="{ openModal: false }">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Workforce Directory</h1>
        <button @click="openModal = true" class="bg-gray-900 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-black transition">
            + Onboard Staff
        </button>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr class="text-xs font-black text-gray-400 uppercase tracking-widest">
                    <th class="p-6">Employee</th>
                    <th class="p-6">Position</th>
                    <th class="p-6">Joining Date</th>
                    <th class="p-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($employees as $emp)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="p-6">
                        <p class="font-bold text-gray-800">{{ $emp->first_name }} {{ $emp->last_name }}</p>
                        <p class="text-xs text-gray-400">{{ $emp->user->email }}</p>
                    </td>
                    <td class="p-6 text-sm text-gray-600">{{ $emp->job_title }}</td>
                    <td class="p-6 text-sm text-gray-600">{{ $emp->joining_date }}</td>
                    <td class="p-6 text-right">
                        <form action="{{ route('admin.employees.destroy', $emp) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-400 hover:text-red-600 font-bold text-xs uppercase">Terminate</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/20 backdrop-blur-sm">
        <div @click.outside="openModal = false" class="bg-white rounded-[2rem] p-10 w-full max-w-lg shadow-2xl">
            <h2 class="text-xl font-bold mb-6">New Employee Registration</h2>
            <form action="{{ route('admin.employees.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="first_name" placeholder="First Name" class="bg-gray-50 border-none rounded-xl p-3 w-full" required>
                    <input type="text" name="last_name" placeholder="Last Name" class="bg-gray-50 border-none rounded-xl p-3 w-full" required>
                </div>
                <input type="email" name="email" placeholder="Corporate Email" class="bg-gray-50 border-none rounded-xl p-3 w-full" required>
                <input type="text" name="job_title" placeholder="Job Title" class="bg-gray-50 border-none rounded-xl p-3 w-full" required>
                <input type="date" name="joining_date" class="bg-gray-50 border-none rounded-xl p-3 w-full" required>
                <button type="submit" class="w-full bg-gray-900 text-white py-4 rounded-xl font-bold">Register Employee</button>
            </form>
        </div>
    </div>
</div>
@endsection