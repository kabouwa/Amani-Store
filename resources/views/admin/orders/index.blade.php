<x-admin.layouts.app title="Gestion des commandes">

    <x-slot:heading>
        <i class="fa-solid fa-box w-4 text-center"></i> Gestion des commandes
    </x-slot:heading>

    <x-slot:headingBtn>
        <a href={{ route('admin.orders.create') }}
            class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-4 py-3 rounded-lg transition
                flex items-center justify-center gap-2 text-sm font-medium w-full md:w-auto md:ml-auto shrink-0">
            <i class="fa-solid fa-plus"></i> Créer une commande
        </a>
    </x-slot:headingBtn>


    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif

    @if(session('error'))
        <x-alert color="red">{{ session('error') }}</x-alert>
    @endif

    {{-- Orders Toolbar --}}
    <x-admin.orders-toolbar>

        <div class="relative" id="labelsBar">

            <button type="button" id="printDropdownToggle"
                    class="cursor-pointer flex justify-center items-center gap-2 bg-amani hover:bg-amani-dark text-white px-4 py-3 rounded-lg
                        transition text-sm font-medium h-full w-full">
                <i class="fa-solid fa-print"></i>
                Imprimer <span id="selectedOrdersCount">0</span> étiquette(s)
                <i class="fa-solid fa-chevron-down text-xs"></i>
            </button>

            <div id="printDropdownPanel" class="hidden absolute right-0 mt-14 w-full md:w-56 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800shadow-lg py-2 z-30">

                {{-- Format A4 — printFormat = 0 --}}
                <form action="{{ route('admin.orders.labels') }}" method="GET" class="js-print-form" data-format="0" target="_blank">
                    <div class="js-codes-container"></div>
                    <input type="hidden" name="printFormat" value="0">
                    <button type="submit"
                            class="cursor-pointer w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200
                                hover:bg-amani/5 dark:hover:bg-amani/10 hover:text-amani transition">
                        <i class="fa-solid fa-file-lines w-4"></i>
                        Format A4
                    </button>
                </form>

                {{-- Format 10x10 — printFormat = 1 --}}
                <form action="{{ route('admin.orders.labels') }}" method="GET" class="js-print-form" data-format="1" target="_blank">
                    <div class="js-codes-container"></div>
                    <input type="hidden" name="printFormat" value="1">
                    <button type="submit"
                            class="cursor-pointer w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200
                                hover:bg-amani/5 dark:hover:bg-amani/10 hover:text-amani transition">
                        <i class="fa-solid fa-tag w-4"></i>
                        Format 10cm × 10cm
                    </button>
                </form>

            </div>
        </div>

    </x-admin.orders-toolbar>

    {{-- Orders table --}}

    @if(count($orders))

    {{-- Desktop / tablet table --}}
    <div class="hidden lg:block bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-left text-gray-600 dark:text-gray-300">
                    {{-- Table header --}}
                    <th class="px-3 py-3 font-semibold text-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="selectAllOrders" class="sr-only peer">
                            <span class="w-5 h-5 rounded-md border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center
                                        transition-all duration-200 peer-checked:bg-amani peer-checked:border-amani peer-checked:text-white text-transparent">
                                <i class="fa-solid fa-check text-[10px] transition-opacity duration-200"></i>
                            </span>
                        </label>
                    </th>
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

                    <td class="px-3 py-3 text-center">
                        @if ($order->hasShipment())
                            {{-- Only orders that actually have a Sendit shipment can be selected for label printing --}}
                            <label class="inline-flex items-center cursor-pointer">
                                {{-- value is the order's code — this is exactly what gets sent as codes[] later --}}
                                <input type="checkbox" class="js-order-checkbox sr-only peer" value="{{ $order->sendit_code }}">
                                <span class="w-5 h-5 rounded-md border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center
                                            transition-all duration-200 peer-checked:bg-amani peer-checked:border-amani peer-checked:text-white text-transparent">
                                    <i class="fa-solid fa-check text-[10px] transition-opacity duration-200"></i>
                                </span>
                            </label>
                        @endif
                    </td>

                    <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $order->code }}</td>
                        <td class="px-5 py-3 font-medium text-gray-800 dark:text-gray-100">
                            <a href={{ route('admin.customers.index', ['search' => $order->customer->name]) }}
                                class="hover:text-amani transition-colors hover:underline">
                                {{ $order->customer->name }}
                            </a>
                        </td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $order->customer->phone }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $order->customer->city }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $order->total_items  }}</td>
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
    <div class="lg:hidden space-y-3">
        @foreach ($orders as $order)
            <div class="js-order-card relative bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-4 transition-all">

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
                    <div class="flex items-center gap-2">
                        <x-admin.order-status :status="$order->status" />

                            @if ($order->hasShipment())
                                <label class="cursor-pointer">
                                    <input type="checkbox" class="js-order-checkbox sr-only peer" value="{{ $order->sendit_code }}">
                                    <span class="w-5 h-5 rounded-md border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center
                                                transition-all duration-200 peer-checked:bg-amani peer-checked:border-amani peer-checked:text-white text-transparent">
                                        <i class="fa-solid fa-check text-[10px] transition-opacity duration-200"></i>
                                    </span>
                                </label>
                            @endif
                    </div>

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

    @push('scripts')
        @vite('resources/js/admin/order-labels.js')
    @endpush

</x-admin.layouts.app>
