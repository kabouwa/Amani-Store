@props([])

<header class="fixed top-0 left-0 right-0 h-18 bg-white/75 border-b border-gray-200 shadow-sm z-40 flex items-center justify-between px-4 md:px-6">

    <div class="flex items-center gap-3">
        {{-- Mobile menu toggle --}}
        <button id="toggleSidebar" class="md:hidden text-gray-600 hover:text-amani p-2 cursor-pointer">
            <span class="text-xl"><i class="fa-solid fa-bars"></i></span>
        </button>
        <a href="/">
            <img src="{{ Vite::asset('resources/images/logo/amani-h.png') }}" alt="Amani Store" class="h-4 md:h-7 w-auto">
        </a>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 rounded-full bg-amani text-white flex items-center justify-center text-md font-semibold hover:shadow-sm hover:shadow-amani transition-all duration-200">
            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
        </a>
        <div class="hidden sm:block">
            <strong class="text-amani text-sm block">AMANI STORE</strong>
            <strong class="text-gray-600 block">Bonjour, {{ auth()->user()->name ?? 'Admin' }}</strong>
        </div>

    </div>

</header>
