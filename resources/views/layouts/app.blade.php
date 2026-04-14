<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Sync-HRMS | Professional Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { background-color: #f8f9fa; color: #333; font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="flex bg-gray-50">
    <aside class="w-64 min-h-screen bg-white shadow-sm border-r border-gray-100 flex flex-col">
        <div class="p-6 font-bold text-2xl tracking-tight text-gray-800">Nexus<span class="text-gray-400">HR</span></div>
        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">Dashboard</a>
            <a href="{{ route('admin.employees.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">Employees</a>
            <a href="{{ route('admin.leaves.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">Leave Requests</a>
            <a href="{{ route('admin.payroll.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">Payroll</a>
        </nav>
        <div class="p-4 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 rounded-lg">Logout</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>