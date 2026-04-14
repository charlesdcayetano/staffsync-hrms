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
</body>
</html>