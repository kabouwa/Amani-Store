<x-admin.layouts.app title="Gestion des commandes">
    <x-slot:heading>
        <i class="fa-solid fa-box w-4 text-center"></i> Gestion des commandes
    </x-slot:heading>

    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif
    @if(session('error'))
        <x-alert color="red">{{ session('error') }}</x-alert>
    @endif

    {{-- Orders Toolbar --}}
    <x-admin.orders-toolbar />


    @if(count($orders))

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
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $order->total_items }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ number_format($order->shipping_price, 2) }} DH</td>
                        <td class="px-5 py-3 font-semibold text-gray-800 dark:text-gray-100">{{ number_format($order->total_price, 2) }} DH</td>
                        <td class="px-5 py-3">
                            <x-admin.order-status :status="$order->status" />
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-2">
                                <a href={{ route('admin.orders.show' , $order->code) }} class="cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-blue-500 hover:bg-blue-500/10 transition">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                @can('update',$order)
                                <a href={{ route('admin.orders.edit', $order->code) }}
                                   class="cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-amani hover:bg-amani/10 transition">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <button type="button" class="js-delete-btn cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition"
                                        data-action="{{ route('admin.orders.destroy', $order->code) }}"
                                        data-modal="deleteOrderModal">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                @if ($order->hasShipment())
                                    <form action={{ route('admin.shipment.destroy', $order->code) }} method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition"
                                            title="Supprimer de Sendit">
                                            <i class="fa-solid fa-ban"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action={{ route('admin.shipment.store', $order->code) }} method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/30 transition"
                                                title="Ajouter dans Sendit">
                                            <i class="fa-solid fa-truck-fast"></i>
                                        </button>
                                    </form>
                                @endif
                                @endcan
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
                            <a href="{{ route('admin.customers.index', ['search' => $order->customer->name]) }}"
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
                    <p><i class="fa-solid fa-box w-4 text-gray-400"></i> {{ $order->total_items }} article(s)</p>
                    <p><i class="fa-solid fa-truck w-4 text-gray-400"></i> {{ number_format($order->shipping_price, 2) }} DH</p>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-800">
                    <span class="font-bold text-gray-800 dark:text-gray-100">{{ number_format($order->total_price, 2) }} DH</span>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.orders.show', $order->code) }}"
                           class="cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-blue-500 hover:bg-blue-500/10 transition">
                            <i class="fa-solid fa-eye"></i>
                        </a>

                        @can('update', $order)
                            <a href="{{ route('admin.orders.edit', $order->code) }}"
                               class="cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-amani hover:bg-amani/10 transition">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <button type="button" class="js-delete-btn cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition"
                                    data-action="{{ route('admin.orders.destroy', $order->code) }}"
                                    data-modal="deleteOrderModal">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @if ($order->hasShipment())
                                <form action="{{ route('admin.shipment.destroy', $order->code) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="js-delete-btn cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition"
                                            title="Supprimer de Sendit"
                                            data-action="{{ route('admin.shipment.destroy', $order->code) }}"
                                            data-modal="deleteShipmentModal">
                                        <i class="fa-solid fa-ban"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.shipment.store', $order->code) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/30 transition"
                                            title="Ajouter dans Sendit">
                                        <i class="fa-solid fa-truck-fast"></i>
                                    </button>
                                </form>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="my-4">
        {{ $orders->links() }}
    </div>

    @else
        {{-- Empty state --}}
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                <i class="fa-solid fa-box-open text-gray-300 dark:text-gray-600 text-2xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 font-medium">Aucune commande trouvée</p>
            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Essayez de modifier vos filtres ou votre recherche.</p>
        </div>
    @endif

    <x-modals.confirm-delete id="deleteOrderModal" title="Supprimer la commande" message="Vous voulez vraiment supprimer cette commande ?" />

</x-admin.layouts.app>