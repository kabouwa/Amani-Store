<x-admin.layouts.app title="Créer une commande">
    <x-slot:heading>
        <i class="fa-solid fa-cart-plus w-4 text-center"></i> Créer une commande
    </x-slot:heading>

    @if($errors->any())
        <x-alert classes="max-w-4xl mx-auto" >Veuillez corriger les erreurs ci-dessous.</x-alert>
    @endif

    <form action="{{ route('admin.orders.store') }}" method="POST" id="orderForm" novalidate>
        @csrf

        {{-- Hidden container: JS injects items[i][slug] / items[i][quantity] here before submit --}}
        <div id="itemsContainer"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left column --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Customer info --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                        Informations client
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                            <p class="js-error text-xs text-red-600 mt-1 hidden"></p>
                            @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Téléphone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                                   placeholder="06XXXXXXXX" maxlength="10" inputmode="numeric"
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                            <p class="js-error text-xs text-red-600 mt-1 hidden"></p>
                            @error('phone')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Instagram</label>
                            <div class="relative">
                                <i class="fa-brands fa-instagram absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" name="instagram" id="instagram" value="{{ old('instagram') }}"
                                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 pl-9 pr-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                              focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                            </div>
                            @error('instagram')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="relative">
                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ville</label>
                            <select name="district_id" id="district_id" required
                                    class="w-full appearance-none rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 pr-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                        focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition cursor-pointer">
                                <option value="" disabled {{ old('district_id') ? '' : 'selected' }}>Choisir la ville</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city['id'] }}" {{ old('district_id') == $city['id'] ? 'selected' : '' }}>
                                        {{ $city['name'] }} | {{ $city['arabic_name'] }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="absolute top-9 right-1.5 pointer-events-none text-gray-400  dark:text-gray-100 text-sm bg-white dark:bg-gray-800 px-1.5">
                                <i class="fa-solid fa-angle-down"></i>
                            </div>

                            @error('district_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse</label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}" required
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                            <p class="js-error text-xs text-red-600 mt-1 hidden"></p>
                            @error('address')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Note</label>
                            <textarea type="text" name="note" id="note"
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 min-h-18 h-24 max-h-30
                                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">{{ old('note') }}</textarea>
                            <p class="js-error text-xs text-red-600 mt-1 hidden"></p>
                            @error('note')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>

                {{-- Product search --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                        Ajouter des articles
                    </h2>

                    <div class="relative" id="productSearchWrapper">
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" id="productSearchInput" placeholder="Rechercher un produit..." autocomplete="off"
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 pl-10 pr-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                        </div>

                        {{-- Results dropdown --}}
                        <div id="productSearchResults"
                             class="hidden absolute left-0 right-0 mt-2 max-h-80 overflow-y-auto bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-lg z-30">
                            {{-- filled by JS --}}
                        </div>
                    </div>

                    {{-- All products data, hidden, for client-side search --}}
                    <script type="application/json" id="productsData">
                        {!! json_encode($products->map(fn($p) => [
                            'slug' => $p->slug,
                            'title' => $p->title,
                            'category' => $p?->category?->title ?? "Non classé",
                            'price' => (float) $p->selling_price,
                            'stock' => $p->stock,
                            'image' => $p->primaryImage?->image ? asset('storage/uploads/' . $p->primaryImage->image) : null,
                        ])) !!}
                    </script>
                </div>

                {{-- Articles table --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide p-6 pb-0">
                        Articles
                    </h2>

                    <div class="overflow-x-auto mt-4">
                        <table class="w-full text-sm min-w-120">
                            <thead>
                                <tr class="text-left text-gray-400 text-xs border-b border-gray-100 dark:border-gray-800">
                                    <th class="px-5 py-3 font-medium">Produit</th>
                                    <th class="px-5 py-3 font-medium text-center">Quantité</th>
                                    <th class="px-5 py-3 font-medium text-right">Prix</th>
                                    <th class="px-5 py-3 font-medium text-right">Total</th>
                                    <th class="px-5 py-3"></th>
                                </tr>
                            </thead>
                            <tbody id="articlesTableBody" class="divide-y divide-gray-100 dark:divide-gray-800">
                                {{-- rows injected by JS --}}
                            </tbody>
                        </table>

                        <div id="noArticles" class="text-center py-10 text-gray-400 text-sm">
                            Aucun article ajouté. Recherchez un produit ci-dessus.
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right column: summary --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                        Résumé
                    </h2>

                    <div class="space-y-2 text-sm mb-6">
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Articles</span>
                            <span id="summaryCount" class="font-medium text-gray-800 dark:text-gray-100">0</span>
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Frais de livraison</span>
                            <span class="font-medium text-gray-800 dark:text-gray-100">20 DH</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-gray-100 dark:border-gray-800 text-base">
                            <span class="font-semibold text-gray-700 dark:text-gray-200">Total</span>
                            <span id="summaryTotal" class="font-bold text-amani">0.00 DH</span>
                        </div>
                    </div>

                    <p id="articlesError" class="text-xs text-red-600 mb-3 hidden">
                        <i class="fa-solid fa-circle-exclamation"></i> Ajoutez au moins un article.
                    </p>

                    <button type="submit"
                            class="cursor-pointer w-full bg-amani hover:bg-amani-dark text-white px-6 py-3 rounded-lg transition flex items-center justify-center gap-2 font-medium">
                        <i class="fa-solid fa-check"></i> Créer la commande
                    </button>
                </div>
            </div>

        </div>

    </form>

    @push('scripts')
        @vite('resources/js/select-search.js')
        @vite('resources/js/admin/order-create.js')
    @endpush

</x-admin.layouts.app>
