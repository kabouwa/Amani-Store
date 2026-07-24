@props([])

<header class="fixed top-0 left-0 right-0 h-18 bg-white/75 dark:bg-gray-900/75 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 shadow-sm z-40 flex items-center justify-between px-4 md:px-6">

    <div class="flex items-center gap-3">
        {{-- Mobile menu toggle --}}
        <button id="toggleSidebar" class="md:hidden text-gray-600 dark:text-gray-300 hover:text-amani dark:hover:text-amani-light p-2 cursor-pointer">
            <span class="text-xl"><i class="fa-solid fa-bars"></i></span>
        </button>

        {{-- Desktop collapse toggle --}}
        <button id="toggleSidebarDesktop" class="hidden md:flex text-gray-600 dark:text-gray-300 hover:text-amani dark:hover:text-amani-light p-2 cursor-pointer">
            <span class="text-xl"><i class="fa-solid fa-bars-staggered" id="collapseIcon"></i></span>
        </button>

        <a href="/">
            <img src="{{ Vite::asset('resources/images/logo/amani-h.png') }}" alt="Amani Store" class="h-4 md:h-7 w-auto">
        </a>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 rounded-full bg-amani dark:bg-amani-light text-white flex items-center justify-center text-md font-semibold hover:shadow-sm hover:shadow-amani dark:hover:shadow-amani-light transition-all duration-200">
            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
        </a>

        <div class="hidden sm:block">
            <strong class="text-amani dark:text-amani-light text-sm block">AMANI STORE</strong>
            <strong class="text-gray-600 dark:text-gray-300 block">Bonjour, {{ auth()->user()->name ?? 'Admin' }}</strong>
        </div>

    </div>

</header>