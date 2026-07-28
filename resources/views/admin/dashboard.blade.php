<x-admin.layouts.app title="Tableau de bord">
    <x-slot:heading>
        <i class="fa-solid fa-chart-line w-4 text-center"></i> Tableau de bord
    </x-slot:heading>

    {{-- Revenue / Profit --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-lg bg-amani/10 text-amani flex items-center justify-center">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
                <span class="text-xs text-gray-400">Revenu (livré)</span>
            </div>
            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($totalRevenue, 0) }} DH</p>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
                <span class="text-xs text-gray-400">Profit total</span>
            </div>
            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($totalProfit, 0) }} DH</p>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <span class="text-xs text-gray-400">Profit ce mois</span>
            </div>
            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($monthProfit, 0) }} DH</p>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <span class="text-xs text-gray-400">Revenu livraison</span>
            </div>
            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($totalShiping, 0) }} DH</p>
        </div>

    </div>

    {{-- Orders overview --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

        {{-- Orders by period --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-amani dark:hover:text-amani-light transition-colors">
                    <i class="fa-solid fa-box text-amani mr-1"></i> Commandes
                </a>
            </h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Aujourd'hui</span>
                    <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $totalDayOrders }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Ce mois</span>
                    <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $totalMonthOrders }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Cette année</span>
                    <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $totalYearOrders }}</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-gray-800">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">Total</span>
                    <span class="font-bold text-amani">{{ $totalOrders }}</span>
                </div>
            </div>
        </div>

        {{-- Basket stats --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                <a href="{{ route('admin.orders.index', ['status' => 'DELIVERED']) }}" class="hover:text-amani dark:hover:text-amani-light transition-colors">
                    <i class="fa-solid fa-basket-shopping text-amani mr-1"></i>  Panier (livré)
                </a>
            </h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Panier moyen</span>
                    <span class="font-semibold text-gray-800 dark:text-gray-100">{{ number_format($avgBaskets, 2) }} DH</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Panier max</span>
                    <span class="font-semibold text-gray-800 dark:text-gray-100">{{ number_format($maxBasket, 2) }} DH</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-gray-800">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Articles vendus</span>
                    <span class="font-bold text-amani">{{ $soldItems ?? 0 }}</span>
                </div>
            </div>
        </div>

        {{-- Products --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                <a href="{{ route('admin.products.index') }}" class="hover:text-amani dark:hover:text-amani-light transition-colors">
                    <i class="fa-solid fa-bag-shopping text-amani mr-1"></i> Produits
                </a>
            </h2>
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 text-center">
                    <p class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $totalProducts }}</p>
                    <p class="text-xs text-gray-400 mt-1">Total</p>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3 text-center">
                    <p class="text-xl font-bold text-green-700 dark:text-green-400">{{ $activeProducts }}</p>
                    <p class="text-xs text-green-600 dark:text-green-500 mt-1">Actifs</p>
                </div>
                <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-3 text-center">
                    <p class="text-xl font-bold text-red-700 dark:text-red-400">{{ $outOfStockProducts }}</p>
                    <p class="text-xs text-red-600 dark:text-red-500 mt-1">Rupture</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Order status pipeline with progress bars --}}
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 mb-6">
        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-5">
            <i class="fa-solid fa-diagram-project text-amani mr-1"></i> Répartition des commandes
        </h2>

        <div class="space-y-4">

            <div>
                <div class="flex justify-between text-sm mb-1.5">
                    <span class="text-gray-600 dark:text-gray-300">En préparation</span>
                    <span class="font-medium text-gray-800 dark:text-gray-100">{{ $preparingOrders }} ({{ $preparingOrdersPercent }}%)</span>
                </div>
                <div class="h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $preparingOrdersPercent }}%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-1.5">
                    <span class="text-gray-600 dark:text-gray-300">À ramasser</span>
                    <span class="font-medium text-gray-800 dark:text-gray-100">{{ $toPickedOrders }} ({{ $toPickedOrdersPercent }}%)</span>
                </div>
                <div class="h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-orange-400 rounded-full" style="width: {{ $toPickedOrdersPercent }}%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-1.5">
                    <span class="text-gray-600 dark:text-gray-300">Ramassées</span>
                    <span class="font-medium text-gray-800 dark:text-gray-100">{{ $pickedOrders }} ({{ $pickedOrdersPercent }}%)</span>
                </div>
                <div class="h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-400 rounded-full" style="width: {{ $pickedOrdersPercent }}%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-1.5">
                    <span class="text-gray-600 dark:text-gray-300">Livrées</span>
                    <span class="font-medium text-gray-800 dark:text-gray-100">{{ $deliveredOrders }} ({{ $deliveredOrdersPercent }}%)</span>
                </div>
                <div class="h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-green-500 rounded-full" style="width: {{ $deliveredOrdersPercent }}%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-1.5">
                    <span class="text-gray-600 dark:text-gray-300">Annulées</span>
                    <span class="font-medium text-gray-800 dark:text-gray-100">{{ $canceledOrders }} ({{ $canceledOrdersPercent }}%)</span>
                </div>
                <div class="h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-red-500 rounded-full" style="width: {{ $canceledOrdersPercent }}%"></div>
                </div>
            </div>

        </div>
    </div>

    {{-- Top lists --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Best products --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                <i class="fa-solid fa-trophy text-amani mr-1"></i> Meilleurs produits
            </h2>
            <div class="space-y-3">
                @forelse($bestProducts as $i => $p)
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-amani/10 text-amani text-xs font-bold flex items-center justify-center shrink-0">
                            {{ $i + 1 }}
                        </span>
                        <a href="{{ route('admin.products.index',['search' => $p->title]) }}"
                            class="flex-1 text-sm text-gray-700 dark:text-gray-300 truncate hover:text-amani dark:hover:text-amani-light transition-colors">
                            {{ $p->title }}
                        </a>
                        <span class="text-xs md:text-sm font-semibold text-gray-800 dark:text-gray-100 shrink-0">
                            {{ $p->sales_times ?? 0 }} vendus
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-4">Aucune vente pour le moment</p>
                @endforelse
            </div>
        </div>

        {{-- Best customers --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                <i class="fa-solid fa-star text-amani mr-1"></i> Meilleurs clients
            </h2>
            <div class="space-y-4">
                @forelse($bestCustomers as $i => $c)
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-amani/10 text-amani text-xs font-bold flex items-center justify-center shrink-0">
                            {{ $i + 1 }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                {{ $c->name }} -
                                <a  href="{{ route('admin.orders.show',  $c->order->code) }}"
                                class="text-xs text-amani dark:text-amani-light hover:underline">
                                    {{ $c->order->code }}
                                </a>
                            </p>
                            
                        </div>
                        <span class="text-sm font-semibold text-gray-800 dark:text-gray-100 shrink-0">{{ number_format($c->total_price, 0) }} DH</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-4">Aucun client pour le moment</p>
                @endforelse
            </div>
        </div>

        {{-- Best cities --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                <i class="fa-solid fa-location-dot text-amani mr-1"></i> Meilleures villes
            </h2>
            <div class="space-y-3">
                @forelse($bestCities as $i => $city)
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-amani/10 text-amani text-xs font-bold flex items-center justify-center shrink-0">
                            {{ $i + 1 }}
                        </span>
                        <span class="flex-1 text-sm text-gray-700 dark:text-gray-300 truncate">{{ $city->city }}</span>
                        <a href="{{ route('admin.orders.index', ['search' => $city->city]) }}"
                           class="text-sm font-semibold text-gray-800 dark:text-gray-100 shrink-0 hover:text-amani">
                            {{ $city->total_orders }} commandes
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-4">Aucune donnée</p>
                @endforelse
            </div>
        </div>

    </div>

</x-admin.layouts.app>