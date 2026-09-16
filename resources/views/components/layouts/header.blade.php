{{-- resources/views/components/public/navbar.blade.php --}}
@props([
    'phone' => ''
])


<header class="sticky top-0 z-40 bg-white dark:bg-gray-950 border-b border-gray-100 dark:border-gray-800">

    {{-- Announcement ticker --}}
    <div class="bg-amani text-white overflow-hidden whitespace-nowrap py-2.5">
        <div class="flex animate-marquee">
            @for ($i = 0; $i < 8; $i++)
                <span class="flex items-center text-xs font-medium tracking-wide px-8 shrink-0">
                    <i class="fa-solid fa-headset mr-2"></i> SERVICE APRÈS-VENTE DISPONIBLE 24H/7J
                </span>
                <span class="flex items-center text-xs font-medium tracking-wide px-8 shrink-0">
                    <i class="fa-brands fa-whatsapp mr-2"></i> WHATSAPP: 06 XX XX XX XX
                </span>
            @endfor
        </div>
    </div>

    {{-- Logo row --}}
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="grid grid-cols-6 items-center h-20">

            {{-- Left: menu (mobile) / search (desktop) --}}
            <div class="flex items-center gap-2">
                <button type="button" id="toggleShopMenu"
                        class="lg:hidden cursor-pointer w-10 h-10 flex items-center justify-center rounded-full text-gray-600 dark:text-gray-300
                               hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-amani transition">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>

            {{-- Center: logo --}}
            <a href="{{ route('home') }}" class="flex justify-center col-span-4">
                <img src="{{ Vite::asset('resources/images/logo/amani-h.png') }}" alt="Amani Store" class="w-50 md:w-64">
            </a>

            {{-- Right: account + cart --}}
            <div class="flex items-center justify-end gap-2">
                <button type="button" id="mobileSearchToggleSm"
                        class="cursor-pointer w-10 h-10 flex items-center justify-center rounded-full text-gray-600 dark:text-gray-300
                               hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-amani transition ml-auto lg:ml-0">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <a href=""
                   class="relative cursor-pointer w-10 h-10 flex items-center justify-center rounded-full text-gray-600 dark:text-gray-300
                          hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-amani transition">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @if (($cartCount ?? 0) > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-amani text-white text-[10px] font-bold flex items-center justify-center">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                    @endif
                </a>
            </div>

        </div>

        {{-- Desktop search bar (collapsible) --}}
        <div id="mobileSearchBar" class="hidden pb-4">
            <form action="{{ route('products.index') }}" method="GET" class="flex gap-2 max-w-lg mx-auto">
                <div class="relative flex-1">
                    <input type="search" name="search" placeholder="Rechercher un produit..."
                        value="{{ request('search') }}"
                        class="w-full rounded-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 pl-10 pr-4 py-2.5 text-sm
                                text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500
                                focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                </div>

                <button type="submit"
                        class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-4 py-2.5 rounded-full transition flex items-center gap-2 shrink-0">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span class="hidden md:inline">Chercher</span>
                </button>
            </form>
        </div>

        {{-- Nav links row — desktop only --}}
        <nav class="hidden lg:flex items-center justify-center gap-1 pb-4">
            <a href="{{ route('home') }}"
               class="px-4 py-2 rounded-full text-sm font-medium transition
                      {{ request()->routeIs('home') ? 'bg-amani text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                Accueil
            </a>
            <a href=""
               class="px-4 py-2 rounded-full text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                Promotions 🎁
            </a>
            <a href=""
               class="px-4 py-2 rounded-full text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                Toutes les collections
            </a>

            <a href=""
               class="px-4 py-2 rounded-full text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                Contact
            </a>
        </nav>
    </div>

    {{-- Tagline strip --}}
    <div class="bg-gray-950 dark:bg-black text-white text-center py-2.5">
        <p class="text-xs md:text-sm font-bold tracking-wide">1ère qualité au Maroc</p>
    </div>

</header>

@push('scripts')
    @vite('resources/js/public/header.js')
@endpush