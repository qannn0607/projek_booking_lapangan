<x-guest-layout>
    <div class="w-full sm:max-w-md px-8 py-10 bg-white/5 backdrop-blur-xl border border-white/10 shadow-[0_0_50px_-12px_rgba(59,130,246,0.5)] rounded-3xl">
        
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Admin <span class="text-blue-500">Booking</span></h2>
            <p class="text-gray-400 mt-2 text-sm">Silakan login dulu</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <input id="email" type="email" name="email" placeholder="Email Address" required autofocus 
                    class="w-full bg-slate-800/50 border-slate-700 text-white rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 transition">
            </div>

            <div>
                <input id="password" type="password" name="password" placeholder="Password" required 
                    class="w-full bg-slate-800/50 border-slate-700 text-white rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 transition">
            </div>

            <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-5 py-3 shadow-lg shadow-blue-500/20 transition-all active:scale-95">
                Login Now
            </button>
        </form>
    </div>
</x-guest-layout>