@props([
    'categories' => [],
    'sorts' => [],
])
@php
    $sorts = [
        [ 'title' => 'Date d\'ajout',      'value' => 'created_at',      'icon_class' => 'fa-solid fa-calendar-plus' ],
        [ 'title' => 'Code commande',      'value' => 'code',            'icon_class' => 'fa-solid fa-hashtag' ],
        [ 'title' => 'Nom du client',      'value' => 'name',            'icon_class' => 'fa-solid fa-user' ],
        [ 'title' => 'Ville du client',    'value' => 'city',            'icon_class' => 'fa-solid fa-location-dot' ],
        [ 'title' => 'Frais de livraison', 'value' => 'shipping_price',  'icon_class' => 'fa-solid fa-truck-fast' ],
        [ 'title' => 'Montant total',      'value' => 'total_price',     'icon_class' => 'fa-solid fa-money-bill-wave' ],
    ];
@endphp
{{-- Toolbar --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">

    {{-- Search --}}
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-3 flex-1" novalidate>
        <input type="hidden" name="category" value="{{ request('category') }}">
        <input type="hidden" name="price_min" value="{{ request('price_min') }}">
        <input type="hidden" name="price_max" value="{{ request('price_max') }}">

        <input type="search" name="search" placeholder="Chercher une commande..."
               value="{{ old('search', request('search')) }}"
               class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500
                      focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">

        <button type="submit"
                class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-4 py-2.5 rounded-lg transition flex items-center gap-2 shrink-0">
            <i class="fa-solid fa-magnifying-glass"></i>
            <span class="hidden md:inline">Chercher</span>
        </button>
    </form>

    @if (request()->except('page'))
    <a href="{{ route('admin.orders.index') }}"
        class="cursor-pointer border-2 border-amani dark:border-amani-light text-amani dark:text-gray-300 dark:bg-gray-800
            hover:bg-amani dark:hover:bg-amani-light hover:text-white dark:hover:text-white font-medium text-sm
            px-4 py-3 rounded-lg transition flex justify-center items-center gap-2 shrink-0">
        <i class="fa-solid fa-rotate-right"></i>
        <span>Réinitialiser</span>
    </a>
    @endif
    
    {{-- Sort dropdown --}}
    <div class="relative shrink-0" id="sortDropdownWrapper">

        <button type="button" id="sortToggle"
                class="cursor-pointer relative w-full sm:w-auto bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:border-amani text-gray-700 dark:text-gray-300 hover:text-amani dark:hover:bg-amani dark:hover:text-white
                    px-4 py-3 rounded-lg transition flex items-center justify-center gap-2 text-sm font-medium">
            <i class="fa-solid fa-arrow-down-wide-short"></i> Trier

            @if(request()->filled('sort'))
                <span class="bg-amani text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">1</span>
            @endif
        </button>

        {{-- Dropdown panel --}}
        <div id="sortPanel"
            class="hidden absolute right-0 mt-2 w-[92vw] sm:w-72 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg z-30 p-5">

            <form action="{{ route('admin.orders.index') }}" method="GET">
                {{-- Preserve everything already applied --}}
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="price_min" value="{{ request('price_min') }}">
                <input type="hidden" name="price_max" value="{{ request('price_max') }}">

                {{-- Direction --}}
                <div class="flex bg-gray-100 dark:bg-gray-800 rounded-lg p-1 mb-4">
                    <label class="flex-1">
                        <input type="radio" name="direction" value="asc" class="sr-only peer"
                            {{ request('direction', 'desc') === 'asc' ? 'checked' : '' }}>
                        <div class="cursor-pointer text-center text-sm py-2 rounded-md text-gray-500 dark:text-gray-400
                                    peer-checked:bg-white dark:peer-checked:bg-amani peer-checked:text-amani dark:peer-checked:text-white peer-checked:shadow-sm transition-all">
                            <i class="fa-solid fa-arrow-up-short-wide mr-1"></i> Croissant
                        </div>
                    </label>

                    <label class="flex-1">
                        <input type="radio" name="direction" value="desc" class="sr-only peer"
                            {{ request('direction', 'desc') === 'desc' ? 'checked' : '' }}>
                        <div class="cursor-pointer text-center text-sm py-2 rounded-md text-gray-500 dark:text-gray-400
                                    peer-checked:bg-white dark:peer-checked:bg-amani peer-checked:text-amani dark:peer-checked:text-white peer-checked:shadow-sm transition-all">
                            <i class="fa-solid fa-arrow-down-short-wide mr-1"></i> Décroissant
                        </div>
                    </label>
                </div>

                {{-- Sort field --}}
                <div class="space-y-1.5 mb-5">
                    @foreach ($sorts as $s)
                    <label class="flex items-center gap-2.5 px-3 py-2 rounded-lg cursor-pointer group hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <input type="radio" name="sort" value="{{ $s['value'] }}" class="sr-only"
                            {{ request('sort', 'created_at') === $s['value'] ? 'checked' : '' }}>

                        <span class="relative w-4 h-4 rounded-full border-2 border-gray-300 dark:border-gray-600 shrink-0
                                    group-has-[:checked]:border-amani transition-colors duration-200">
                            <span class="absolute inset-0.5 rounded-full bg-amani scale-0 group-has-[:checked]:scale-100 transition-transform duration-200"></span>
                        </span>

                        <i class="{{ $s['icon_class'] }} text-gray-400 dark:text-gray-500 w-4 text-xs"></i>
                        <span class="text-sm text-gray-700 dark:text-gray-200">{{ $s['title'] }}</span>
                    </label>
                    @endforeach
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
                class="cursor-pointer relative w-full sm:w-auto bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:border-amani text-gray-700 dark:text-gray-300 hover:text-amani dark:hover:text-white dark:hover:bg-amani
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
            class="hidden absolute right-0 mt-2 w-[92vw] sm:w-[520px] bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg z-30 p-5">

            <form action="{{ route('admin.orders.index') }}" method="GET">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <input type="hidden" name="direction" value="{{ request('direction') }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Price min --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Prix min</label>
                        <div class="relative">
                            <input type="number" name="price_min" placeholder="0" min="0" step="0.01"
                                value="{{ request('price_min') }}"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2.5 pr-10 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 text-sm
                                        focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xs pointer-events-none">DH</span>
                        </div>
                    </div>

                    {{-- Price max --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Prix max</label>
                        <div class="relative">
                            <input type="number" name="price_max" placeholder="1000" min="0" step="0.01"
                                value="{{ request('price_max') }}"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2.5 pr-10 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 text-sm
                                        focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xs pointer-events-none">DH</span>
                        </div>
                    </div>
                    
                    {{-- Status --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Statut</label>
                    <div class="relative">
                        <select name="status"
                                class="w-full appearance-none rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2.5 pr-9 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition cursor-pointer">
                            <option value="">Tous les statuts</option>
                            <option value="PENDING"         {{ request('status') === 'PENDING' ? 'selected' : '' }}>En attente</option>
                            <option value="TO_PREPARE"      {{ request('status') === 'TO_PREPARE' ? 'selected' : '' }}>À préparer</option>
                            <option value="PREPARING"       {{ request('status') === 'PREPARING' ? 'selected' : '' }}>En cours de préparation</option>
                            <option value="NEW_DESTINATION" {{ request('status') === 'NEW_DESTINATION' ? 'selected' : '' }}>À changer</option>
                            <option value="TOPICKUP"        {{ request('status') === 'TOPICKUP' ? 'selected' : '' }}>Ramassage en cours</option>
                            <option value="PICKEDUP"        {{ request('status') === 'PICKEDUP' ? 'selected' : '' }}>Ramassé</option>
                            <option value="WAREHOUSE"       {{ request('status') === 'WAREHOUSE' ? 'selected' : '' }}>Entrepôt</option>
                            <option value="TRANSIT"         {{ request('status') === 'TRANSIT' ? 'selected' : '' }}>En transit</option>
                            <option value="DISTRIBUTED"     {{ request('status') === 'DISTRIBUTED' ? 'selected' : '' }}>Distribué</option>
                            <option value="DELIVERING"      {{ request('status') === 'DELIVERING' ? 'selected' : '' }}>En cours de livraison</option>
                            <option value="UNREACHABLE"     {{ request('status') === 'UNREACHABLE' ? 'selected' : '' }}>Injoignable</option>
                            <option value="POSTPONED"       {{ request('status') === 'POSTPONED' ? 'selected' : '' }}>Reporté</option>
                            <option value="DELIVERED"       {{ request('status') === 'DELIVERED' ? 'selected' : '' }}>Livré</option>
                            <option value="CANCELED"        {{ request('status') === 'CANCELED' ? 'selected' : '' }}>Annulé</option>
                            <option value="REJECTED"        {{ request('status') === 'REJECTED' ? 'selected' : '' }}>Refusé</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xs pointer-events-none"></i>
                    </div>
                </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between gap-3 mt-5 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.orders.index') }}"
                    class="cursor-pointer text-sm text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition flex items-center gap-1.5">
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

@push('scripts')
    @vite('resources/js/toolbar.js')
@endpush