<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Sync-HRMS | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { 
            background: rgba(255, 255, 255, 0.7); 
            backdrop-filter: blur(16px); 
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4); 
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center bg-[url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=2000')] bg-cover bg-center">
    
    <div class="absolute inset-0 bg-gray-900/10"></div>

    <div class="glass p-10 md:p-14 rounded-[2.5rem] shadow-2xl w-full max-w-md relative z-10 transition-all">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Staff Sync<span class="text-gray-400">-HRMS</span></h1>
            <p class="text-gray-500 mt-2 font-medium">Human Resource Management System</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-600 text-sm rounded-2xl border border-red-100">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Email Address</label>
                <input type="email" name="email" required autofocus
                    class="w-full px-5 py-4 rounded-2xl bg-white/50 border border-white/20 focus:bg-white focus:ring-4 focus:ring-gray-100 outline-none transition-all duration-300 placeholder-gray-400"
                    placeholder="name@company.com">
            </div>

            <div class="space-y-2">
                <div class="flex justify-between px-1">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest">Password</label>
                    <a href="#" class="text-xs font-bold text-gray-400 hover:text-gray-900 transition">Forgot?</a>
                </div>
                <input type="password" name="password" required
                    class="w-full px-5 py-4 rounded-2xl bg-white/50 border border-white/20 focus:bg-white focus:ring-4 focus:ring-gray-100 outline-none transition-all duration-300 placeholder-gray-400"
                    placeholder="••••••••">
            </div>

            <div class="flex items-center px-1">
                <input type="checkbox" id="remember" name="remember" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                <label for="remember" class="ml-2 text-sm font-medium text-gray-500">Keep me signed in</label>
            </div>

            <button type="submit" 
                class="w-full bg-gray-900 text-white py-5 rounded-2xl font-bold text-lg hover:bg-black transition-all duration-300 shadow-xl shadow-gray-900/20 active:scale-[0.98]">
                Access System
            </button>
        </form>

        <footer class="mt-12 text-center">
            <p class="text-xs text-gray-400 font-medium tracking-tight">
                © 2026 Staff Sync-HRMS. All rights reserved.
            </p>
        </footer>
    </div>

</body>
</html>