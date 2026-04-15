<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Sync - HRMS | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F9FAFB; }
        [x-cloak] { display: none !important; }
        .active-nav { background-color: #F3F4F6; color: #111827 !important; font-weight: 700; }
        /* Smooth transition for search focus */
        .search-container:focus-within { width: 400px; }
    </style>
</head>
<body class="flex min-h-screen">

    <nav class="w-66 h-screen sticky top-0 bg-white border-r border-gray-200 px-4 py-6 flex flex-col justify-between">
        <div>
            <div class="text-2xl font-black text-gray-900 px-4 mb-10 tracking-tighter">
                Staff Sync-<span class="text-gray-400">HRMS</span>
            </div>
            
            <div class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-xl text-gray-500 hover:bg-gray-50 transition {{ request()->routeIs('admin.dashboard') ? 'active-nav' : '' }}">Dashboard</a>
                <a href="{{ route('admin.employees.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-500 hover:bg-gray-50 transition {{ request()->routeIs('admin.employees.*') ? 'active-nav' : '' }}">Employees</a>
                <a href="{{ route('admin.leaves.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-500 hover:bg-gray-50 transition {{ request()->routeIs('admin.leaves.*') ? 'active-nav' : '' }}">Leaves</a>
                <a href="{{ route('admin.payroll.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-500 hover:bg-gray-50 transition {{ request()->routeIs('admin.payroll.*') ? 'active-nav' : '' }}">Payroll</a>
            </div>
        </div>

        <div class="px-4 pb-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-red-400 hover:bg-red-50 hover:text-red-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4-4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout System
                </button>
            </form>
        </div>
    </nav>

    <div class="flex-1 flex flex-col">
        
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10 sticky top-0 z-40">
            
            <div class="w-10 md:block hidden"></div>

            <div class="flex-1 max-w-md mx-8">
    <form action="{{ route('admin.employees.index') }}" method="GET">
        <div class="search-container relative w-full transition-all duration-300">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Search employees or records..." 
                class="w-full bg-gray-50 border-none rounded-2xl py-2.5 pl-11 pr-4 text-sm placeholder-gray-400 focus:ring-2 focus:ring-gray-100 transition-all outline-none"
            >
            <button type="submit" class="hidden"></button>
        </div>
    </form>
</div>


            <div class="flex items-center gap-6">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-900 transition relative rounded-full hover:bg-gray-50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                        @endif
                    </button>
                    
                    <div x-show="open" @click.outside="open = false" x-cloak x-transition
                         class="absolute right-0 mt-4 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 py-4 z-50">
                        <div class="px-5 pb-3 border-b border-gray-50 font-black text-[10px] uppercase text-gray-400 tracking-widest">Notifications</div>
                        <div class="max-h-64 overflow-y-auto">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <div class="px-5 py-4 hover:bg-gray-50 text-sm text-gray-700 border-b border-gray-50 last:border-0">
                                    {{ $notification->data['message'] ?? 'New system alert' }}
                                </div>
                            @empty
                                <div class="px-5 py-8 text-center text-sm text-gray-400 italic">No new alerts</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="relative" x-data="{ menu: false }">
                    <button @click="menu = !menu" class="flex items-center gap-3 focus:outline-none group">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-900 leading-none">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tight mt-1">{{ auth()->user()->is_admin ? 'Administrator' : 'Staff' }}</p>
                        </div>
                        <img src="{{ auth()->user()->employee->profile_photo ? asset('storage/' . auth()->user()->employee->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=f3f4f6&color=a1a1aa' }}" 
                             class="w-10 h-10 rounded-2xl object-cover border-2 border-white shadow-sm group-hover:shadow-md transition">
                    </button>

                    <div x-show="menu" @click.outside="menu = false" x-cloak x-transition
                         class="absolute right-0 mt-4 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-50">
                        <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            <span>My Profile</span>
                        </a>
                        <hr class="border-gray-50 my-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm font-bold text-red-500 hover:bg-red-50 transition flex items-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4-4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-10">
            @yield('content')
        </main>
    </div>

</body>
</html>