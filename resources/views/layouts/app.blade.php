<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Booking Lapangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0b0f1a] text-gray-200 antialiased font-sans">
    
    <nav class="border-b border-white/5 bg-white/5 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-wider text-blue-500">BOOKING<span class="text-white">FIELD</span></h1>
            
            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-400">Halo, <span class="text-white font-semibold">{{ Auth::user()->name }}</span></span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm bg-red-500/10 text-red-500 px-4 py-1.5 rounded-lg hover:bg-red-500 hover:text-white transition">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="py-10">
        {{ $slot }}
    </main>
</body>
</html>