<div class="min-h-screen flex items-center justify-center bg-gray-100 bg-[url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80')] bg-cover bg-center">
    <div class="glass p-10 rounded-3xl shadow-2xl w-full max-w-md">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back</h2>
        <p class="text-gray-500 mb-8">Please enter your details to sign in.</p>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" class="w-full px-4 py-3 rounded-xl bg-white/50 border border-white/30 focus:ring-2 focus:ring-gray-200 outline-none transition" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-xl bg-white/50 border border-white/30 focus:ring-2 focus:ring-gray-200 outline-none transition" required>
            </div>
            <button class="w-full bg-gray-900 text-white py-3 rounded-xl font-bold hover:bg-black transition shadow-lg shadow-gray-300">Sign In</button>
        </form>
    </div>
</div>