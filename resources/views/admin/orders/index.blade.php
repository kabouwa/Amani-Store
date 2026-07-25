<x-admin.layouts.app title="Gestion des commandes">
    <x-slot:heading>
        <i class="fa-solid fa-bag-shopping w-4 text-center"></i> Gestion des commandes
    </x-slot:heading>

    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif

    {{-- Desktop / tablet table --}}
    <div class="hidden md:block bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-left text-gray-600 dark:text-gray-300">
                    <th class="px-5 py-3 font-semibold">Code</th>
                    <th class="px-5 py-3 font-semibold">Client</th>
                    <th class="px-5 py-3 font-semibold">Téléphone</th>
                    <th class="px-5 py-3 font-semibold">Ville</th>
                    <th class="px-5 py-3 font-semibold">Articles</th>
                    <th class="px-5 py-3 font-semibold">Livraison</th>
                    <th class="px-5 py-3 font-semibold">Total</th>
                    <th class="px-5 py-3 font-semibold">Statut</th>
                    <th class="px-5 py-3 font-semibold text-right"><span class="mr-24">Actions</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($orders as $order)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                    <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $order->code }}</td>
                        <td class="px-5 py-3 font-medium text-gray-800 dark:text-gray-100">
                            <a href={{ route('admin.customers.index', ['search' => $order->customer->name]) }}
                                class="hover:text-amani transition-colors hover:underline">
                                {{ $order->customer->name }}
                            </a>
                        </td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $order->customer->phone }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $order->customer->city }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $order->items->sum('quantity') }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ number_format($order->shipping_price, 2) }} DH</td>
                        <td class="px-5 py-3 font-semibold text-gray-800 dark:text-gray-100">{{ number_format($order->total_price, 2) }} DH</td>
                        <td class="px-5 py-3">
                            <x-admin.order-status :status="$order->status" />
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-2">
                                <button type="button" class="js-order-view cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-blue-500 hover:bg-blue-500/10 transition"
                                        data-order-id="{{ $order->id }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <a href="{{ route('admin.orders.index', $order->id) }}"
                                   class="cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-amani hover:bg-amani/10 transition">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <button type="button" class="js-delete-btn cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition"
                                        data-action="{{ route('admin.orders.index', $order->id) }}"
                                        data-modal="cancelOrderModal">
                                    <i class="fa-solid fa-ban"></i>
                                </button>
                                <button type="button" class="js-delete-btn cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/30 transition"
                                        data-action="{{ route('admin.orders.index', $order->id) }}"
                                        data-modal="senditOrderModal">
                                    <i class="fa-solid fa-truck-fast"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Mobile card list --}}
    <div class="md:hidden space-y-3">
        @foreach ($orders as $order)
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-4">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <span class="font-semibold text-gray-800 dark:text-gray-100 block">
                            <a href={{ route('admin.customers.index', ['search' => $order->customer->name]) }}
                                class="hover:text-amani transition-colors hover:underline">
                                {{ $order->customer->name }}
                            </a>
                        </span>
                        <span class="text-xs text-gray-400">{{ $order->code }}</span>
                    </div>
                    <x-admin.order-status :status="$order->status" />
                </div>

                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1 mb-3">
                    <p><i class="fa-solid fa-phone w-4 text-gray-400"></i> {{ $order->customer->phone }}</p>
                    <p><i class="fa-solid fa-location-dot w-4 text-gray-400"></i> {{ $order->customer->city }}</p>
                    <p><i class="fa-solid fa-box w-4 text-gray-400"></i> {{ $order->items->sum('quantity') }} article(s)</p>
                    <p><i class="fa-solid fa-truck w-4 text-gray-400"></i> {{ number_format($order->shipping_price, 2) }} DH</p>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-800">
                    <span class="font-bold text-gray-800 dark:text-gray-100">{{ number_format($order->total_price, 2) }} DH</span>

                    <div class="flex gap-2">
                        
                        <button type="button" class="js-order-view cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-blue-500 hover:bg-blue-500/10 transition"
                                data-order-id="{{ $order->id }}">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <a href="{{ route('admin.orders.index', $order->id) }}"
                           class="cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-amani hover:bg-amani/10 transition">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <button type="button" class="js-delete-btn cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition"
                                data-action="{{ route('admin.orders.index', $order->id) }}"
                                data-modal="cancelOrderModal">
                            <i class="fa-solid fa-ban"></i>
                        </button>
                        <button type="button" class="js-delete-btn cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/30 transition"
                                data-action="{{ route('admin.orders.index', $order->id) }}"
                                data-modal="senditOrderModal">
                            <i class="fa-solid fa-truck-fast"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <x-admin.order-details />
    <x-modals.confirm-delete id="cancelOrderModal" title="Annuler la commande" message="Vous voulez vraiment annuler de cette commande ?" action="Confirmer"/>
    <x-modals.confirm-delete id="senditOrderModal" title="Envoyer via Sendit" message="Confirmer l'envoi de cette commande à Sendit ?" />

    @push('scripts')
        @vite(['resources/js/admin/order-details.js'])
    @endpush
</x-admin.layouts.app>