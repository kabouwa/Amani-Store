<x-admin.layouts.app title="Gestion des produits">
    <x-slot:heading>
        <i class="fa-solid fa-bag-shopping w-4 text-center"></i> Gestion des produits
    </x-slot:heading>

    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif

    {{-- Toolbar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between align-stretch gap-3 mb-6">

        {{-- Search --}}
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-3 w-full md:w-auto md:max-w-md flex-1" novalidate>
            <input type="search" name="search" placeholder="Chercher un produit..."
                value="{{ old('search', request('search')) }}"
                class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900
                        focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">

            <button type="submit"
                    class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-4 py-2.5 rounded-lg transition flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass"></i> <span class="hidden md:inline">Chercher</span> 
            </button>

            @if (request()->filled('search'))
                <a href="{{ route('admin.products.index') }}"
                class="cursor-pointer border-2 border-amani text-amani hover:bg-amani hover:text-white px-4 py-2.5 rounded-lg transition flex items-center gap-2">
                    <i class="fa-solid fa-rotate-right"></i>
                </a>
            @endif
        </form>

        <a href="{{ route('admin.products.create') }}"
        class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-4 py-3 rounded-lg transition
                flex items-center justify-center gap-2 text-sm font-medium block">
            <i class="fa-solid fa-plus"></i> Ajouter un produit
        </a>
        


    </div>

    <form action="{{ route('admin.products.index') }}" method="GET" id="filterForm"
      class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">

        {{-- Keep search term when filters change --}}
        <input type="hidden" name="search" value="{{ request('search') }}">

        {{-- Category filter --}}
        <div class="relative w-full sm:w-56">
            <select name="category_id" onchange="document.getElementById('filterForm').submit()"
                    class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-2.5 pr-9 text-gray-900 bg-white text-sm
                        focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition cursor-pointer">
                <option value="">Toutes les catégories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->title }}
                    </option>
                @endforeach
            </select>
            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
        </div>

        {{-- Status filter --}}
        <div class="relative w-full sm:w-44">
            <select name="is_active" onchange="document.getElementById('filterForm').submit()"
                    class="w-full appearance-none rounded-lg border border-gray-300 px-4 py-2.5 pr-9 text-gray-900 bg-white text-sm
                        focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition cursor-pointer">
                <option value="">Tous les statuts</option>
                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Actif</option>
                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactif</option>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
        </div>

        {{-- Reset filters (only shows if any filter is active) --}}
        @if (request()->filled('category_id') || request()->filled('is_active'))
            <a href="{{ route('admin.products.index', ['search' => request('search')]) }}"
            class="cursor-pointer text-sm text-gray-500 hover:text-amani transition flex items-center gap-1.5">
                <i class="fa-solid fa-xmark"></i> Réinitialiser les filtres
            </a>
        @endif

    </form>

    <div class="text-gray-400 my-3">
        <p>
            {{ count($products) }} {{ count($products) > 1 ? 'produits ont été trouvés.' : 'produits a été trouvé.' }}
        </p>
    </div>

    {{-- Grid --}}
    @if(count($products))
        <div id="productsGrid" class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-5">
            @foreach ($products as $p)
                <x-admin.product-card :product="$p" />
            @endforeach
        </div>
    @else
        {{-- Empty state --}}
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                <i class="fa-solid fa-bag-shopping text-gray-300 text-2xl"></i>
            </div>
            <p class="text-gray-500 font-medium">Aucun produit pour le moment</p>
            <p class="text-sm text-gray-400 mt-1">Commencez par ajouter votre premier produit.</p>
            <a href="{{ route('admin.products.create') }}"
               class="cursor-pointer mt-4 bg-amani hover:bg-amani-dark text-white px-5 py-2.5 rounded-lg transition text-sm font-medium">
                <i class="fa-solid fa-plus mr-1"></i> Ajouter un produit
            </a>
        </div>
    @endif

</x-admin.layouts.app>