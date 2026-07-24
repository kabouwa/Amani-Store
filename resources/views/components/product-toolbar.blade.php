@props([
    'categories' => []
])
{{-- Toolbar --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">

    {{-- Search --}}
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-3 flex-1" novalidate>
        <input type="hidden" name="category" value="{{ request('category') }}">
        <input type="hidden" name="is_active" value="{{ request('is_active') }}">
        <input type="hidden" name="price_min" value="{{ request('price_min') }}">
        <input type="hidden" name="price_max" value="{{ request('price_max') }}">

        <input type="search" name="search" placeholder="Chercher un produit..."
               value="{{ old('search', request('search')) }}"
               class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900
                      focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">

        <button type="submit"
                class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-4 py-2.5 rounded-lg transition flex items-center gap-2 shrink-0">
            <i class="fa-solid fa-magnifying-glass"></i>
            <span class="hidden md:inline">Chercher</span>
        </button>

        @if (request()->filled('search'))
            <a href="{{ route('admin.products.index') }}"
               class="cursor-pointer border-2 border-amani text-amani hover:bg-amani hover:text-white px-4 py-2.5 rounded-lg transition flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-rotate-right"></i>
            </a>
        @endif
    </form>

    {{-- Sort dropdown --}}
    <div class="relative shrink-0" id="sortDropdownWrapper">

        <button type="button" id="sortToggle"
                class="cursor-pointer relative w-full sm:w-auto bg-white border border-gray-300 hover:border-amani text-gray-700 hover:text-amani
                    px-4 py-3 rounded-lg transition flex items-center justify-center gap-2 text-sm font-medium">
            <i class="fa-solid fa-arrow-down-wide-short"></i>
            <span class="hidden md:inline">Trier</span>

            @if(request()->filled('sort'))
                <span class="bg-amani text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">1</span>
            @endif
        </button>

        {{-- Dropdown panel --}}
        <div id="sortPanel"
            class="hidden absolute right-0 mt-2 w-[92vw] sm:w-72 bg-white rounded-xl border border-gray-200 shadow-lg z-30 p-5">

            <form action="{{ route('admin.products.index') }}" method="GET">
                {{-- Preserve everything already applied --}}
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="category" value="{{ request('category') }}">
                <input type="hidden" name="is_active" value="{{ request('is_active') }}">
                <input type="hidden" name="price_min" value="{{ request('price_min') }}">
                <input type="hidden" name="price_max" value="{{ request('price_max') }}">

                {{-- Direction --}}
                <div class="flex bg-gray-100 rounded-lg p-1 mb-4">
                    <label class="flex-1">
                        <input type="radio" name="direction" value="asc" class="sr-only peer"
                            {{ request('direction', 'desc') === 'asc' ? 'checked' : '' }}>
                        <div class="cursor-pointer text-center text-sm py-2 rounded-md text-gray-500
                                    peer-checked:bg-white peer-checked:text-amani peer-checked:shadow-sm transition-all">
                            <i class="fa-solid fa-arrow-up-short-wide mr-1"></i> Croissant
                        </div>
                    </label>
                    <label class="flex-1">
                        <input type="radio" name="direction" value="desc" class="sr-only peer"
                            {{ request('direction', 'desc') === 'desc' ? 'checked' : '' }}>
                        <div class="cursor-pointer text-center text-sm py-2 rounded-md text-gray-500
                                    peer-checked:bg-white peer-checked:text-amani peer-checked:shadow-sm transition-all">
                            <i class="fa-solid fa-arrow-down-short-wide mr-1"></i> Décroissant
                        </div>
                    </label>
                </div>

                {{-- Sort field --}}
                <div class="space-y-1.5 mb-5">

                    <label class="flex items-center gap-2.5 px-3 py-2 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="sort" value="created_at" class="accent-amani"
                            {{ request('sort', 'created_at') === 'created_at' ? 'checked' : '' }}>
                        <i class="fa-solid fa-calendar-plus text-gray-400 w-4 text-xs"></i>
                        <span class="text-sm text-gray-700">Date d'ajout</span>
                    </label>

                    <label class="flex items-center gap-2.5 px-3 py-2 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="sort" value="purchase_price" class="accent-amani"
                            {{ request('sort') === 'purchase_price' ? 'checked' : '' }}>
                        <i class="fa-solid fa-money-bill-wave text-gray-400 w-4 text-xs"></i>
                        <span class="text-sm text-gray-700">Prix d'achat</span>
                    </label>

                    <label class="flex items-center gap-2.5 px-3 py-2 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="sort" value="selling_price" class="accent-amani"
                            {{ request('sort') === 'selling_price' ? 'checked' : '' }}>
                        <i class="fa-solid fa-tag text-gray-400 w-4 text-xs"></i>
                        <span class="text-sm text-gray-700">Prix de vente</span>
                    </label>

                    <label class="flex items-center gap-2.5 px-3 py-2 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="sort" value="title" class="accent-amani"
                            {{ request('sort') === 'title' ? 'checked' : '' }}>
                        <i class="fa-solid fa-font text-gray-400 w-4 text-xs"></i>
                        <span class="text-sm text-gray-700">Titre</span>
                    </label>

                </div>

                <button type="submit"
                        class="cursor-pointer w-full bg-amani hover:bg-amani-dark text-white py-2.5 rounded-lg transition text-sm font-medium flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-down-wide-short"></i> Trier
                </button>
            </form>

        </div>

    </div>

  
    {{-- Filter dropdown --}}
    <div class="relative shrink-0" id="filterDropdownWrapper">

        <button type="button" id="filterToggle"
                class="cursor-pointer relative w-full sm:w-auto bg-white border border-gray-300 hover:border-amani text-gray-700 hover:text-amani
                       px-4 py-3 rounded-lg transition flex items-center justify-center gap-2 text-sm font-medium">
            <i class="fa-solid fa-sliders"></i>
            <span>Filtres</span>

            @php
                $activeFilters = collect([
                    request('category'), request('is_active'), request('price_min'), request('price_max')
                ])->filter(fn($v) => filled($v))->count();
            @endphp

            @if($activeFilters > 0)
                <span class="bg-amani text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                    {{ $activeFilters }}
                </span>
            @endif
        </button>

        {{-- Dropdown panel --}}
        <div id="filterPanel"
             class="hidden absolute right-0 mt-2 w-[92vw] sm:w-[520px] bg-white rounded-xl border border-gray-200 shadow-lg z-30 p-5">

            <form action="{{ route('admin.products.index') }}" method="GET">
                <input type="hidden" name="search" value="{{ request('search') }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Category --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Catégorie</label>
                        <div class="relative">
                            <select name="category"
                                    class="w-full appearance-none rounded-lg border border-gray-300 px-3 py-2.5 pr-9 text-gray-900 bg-white text-sm
                                           focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition cursor-pointer">
                                <option value="">Toutes les catégories</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                        {{ $cat->title }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Statut</label>
                        <div class="relative">
                            <select name="is_active"
                                    class="w-full appearance-none rounded-lg border border-gray-300 px-3 py-2.5 pr-9 text-gray-900 bg-white text-sm
                                           focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition cursor-pointer">
                                <option value="">Tous les statuts</option>
                                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Actif</option>
                                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactif</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>

                    {{-- Price min --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Prix min</label>
                        <div class="relative">
                            <input type="number" name="price_min" placeholder="0" min="0" step="0.01"
                                   value="{{ request('price_min') }}"
                                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 pr-10 text-gray-900 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none">DH</span>
                        </div>
                    </div>

                    {{-- Price max --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Prix max</label>
                        <div class="relative">
                            <input type="number" name="price_max" placeholder="1000" min="0" step="0.01"
                                   value="{{ request('price_max') }}"
                                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 pr-10 text-gray-900 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none">DH</span>
                        </div>
                    </div>

                    {{-- Stock min --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Stock min</label>
                        <div class="relative">
                            <input type="number" name="stock_min" placeholder="0" min="0" step="0.01"
                                   value="{{ request('stock_min') }}"
                                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 pr-10 text-gray-900 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none">DH</span>
                        </div>
                    </div>

                    {{-- Stock max --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Stock max</label>
                        <div class="relative">
                            <input type="number" name="stock_max" placeholder="1000" min="0" step="0.01"
                                   value="{{ request('stock_max') }}"
                                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 pr-10 text-gray-900 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none">DH</span>
                        </div>
                    </div>

                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between gap-3 mt-5 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.products.index') }}"
                       class="cursor-pointer text-sm text-gray-500 hover:text-red-600 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-trash-can"></i> Vider
                    </a>

                    <button type="submit"
                            class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-5 py-2.5 rounded-lg transition text-sm font-medium flex items-center gap-2">
                        <i class="fa-solid fa-filter"></i> Filtrer
                    </button>
                </div>

            </form>
        </div>

    </div>

</div>