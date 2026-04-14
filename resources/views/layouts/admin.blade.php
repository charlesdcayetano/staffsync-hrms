<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusHR | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F3F4F6; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
    </style>
</head>
<body class="flex">
    <nav class="w-64 h-screen sticky top-0 bg-white border-r border-gray-200 px-4 py-6">
        <div class="text-2xl font-bold text-gray-800 px-4 mb-10">Nexus<span class="text-gray-400">HR</span></div>
        <div class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-lg bg-gray-100 text-gray-900 font-semibold">Dashboard</a>
            <a href="{{ route('admin.employees.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition">Employees</a>
            <a href="{{ route('admin.leaves.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition">Leaves</a>
            <a href="{{ route('admin.payroll.index') }}" class="block px-4 py-2.5 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition">Payroll</a>
        </div>
    </nav>

    <div class="flex-1">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-end px-8">
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-600">{{ auth()->user()->name }}</span>
                <div class="w-8 h-8 rounded-full bg-gray-200"></div>
            </div>
        </header>
        <main class="p-8">
            @yield('content')
        </main>
    </div>

    <div class="relative group" x-data="{ open: false }">
    <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-900 transition relative">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
        @endif
    </button>
    
    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 py-4 z-50">
        <div class="px-4 pb-2 border-b border-gray-50 font-bold text-xs uppercase text-gray-400">Notifications</div>
        @forelse(auth()->user()->unreadNotifications as $notification)
            <div class="px-4 py-3 hover:bg-gray-50 text-sm text-gray-700 border-b border-gray-50 last:border-0">
                {{ $notification->data['message'] }}
            </div>
        @empty
            <div class="px-4 py-3 text-sm text-gray-400">All caught up!</div>
        @endforelse
    </div>
</div>

</body>
</html>