<x-admin.layouts.app title="Détail de commande">

    <x-slot:heading>
        <i class="fa-solid fa-circle-info w-4 text-center"></i> Détail de commande
    </x-slot:heading>
    
    {{-- Header : retour + code commande + statut --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{url()->previous()}}"
               class="w-9 h-9 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-amani hover:bg-amani/10 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    Commande #{{ $order->code }}
                </h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Créée le {{ $order->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>
        </div>

        <x-admin.order-status :status="$order->status" />
    </div>


    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif
    @if(session('error'))
        <x-alert color="red">{{ session('error') }}</x-alert>
    @endif
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <x-alert color="red">{{ $error }}</x-alert>
        @endforeach
    @endif
    
    {{-- Actions --}}
    @can('update',$order)
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('admin.orders.edit', $order->code) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
            <i class="fa-solid fa-pen"></i>
            Modifier
        </a>

        @if ($order->sendit_code)
            <form action="{{ route('admin.shipment.destroy', $order->code) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="button"
                        class="js-delete-btn inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-red-600 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 transition cursor-pointer"
                        data-action="{{ route('admin.shipment.destroy', $order->code) }}"
                        data-modal="deleteShipmentModal">
                    <i class="fa-solid fa-ban"></i>
                    Retirer de Sendit
                </button>
            </form>
        @else
            <form action="{{ route('admin.shipment.store', $order->code) }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-green-600 bg-green-50 dark:bg-green-900/30 hover:bg-green-100 dark:hover:bg-green-900/50 transition cursor-pointer">
                    <i class="fa-solid fa-truck-fast"></i>
                    Envoyer vers Sendit
                </button>
            </form>
        @endif
        

        <button type="button"
                class="js-delete-btn ml-auto inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-red-600 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 transition cursor-pointer"
                data-action="{{ route('admin.orders.destroy', $order->code) }}"
                data-modal="deleteOrderModal">
            <i class="fa-solid fa-trash"></i>
            Supprimer la commande
        </button>
    </div>
    @endcan

    {{-- Grid principal --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Colonne gauche : commande + articles --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Infos commande --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-5">
                <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-4">Informations de livraison</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Agence</p>
                        <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $order->shipping_agency }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Frais de livraison</p>
                        <p class="text-gray-800 dark:text-gray-200 font-medium">{{ number_format($order->shipping_price, 2) }} DH</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Code Sendit</p>
                        <p class="text-gray-800 dark:text-gray-200 font-medium">
                            {{ $order->sendit_code ?? '—' }}
                        </p>
                    </div>
                </div>

                @if ($order->note)
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <p class="text-gray-400 text-xs mb-1">Note</p>
                        <p class="text-gray-700 dark:text-gray-300">{{ $order->note }}</p>
                    </div>
                @endif
            </div>

            {{-- Articles --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100 p-5 pb-0">Articles</h2>
                <table class="w-full text-sm mt-4">
                    <thead>
                        <tr class="text-left text-gray-400 text-xs border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 font-medium">Produit</th>
                            <th class="px-5 py-3 font-medium text-center">Qté</th>
                            <th class="px-5 py-3 font-medium text-right">Prix</th>
                            <th class="px-5 py-3 font-medium text-right">Sous-total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        @if ($item->product)
                                            <img src="{{ $item->product->primaryImage?->image ?? asset('storage/products/default-image.png') }}"
                                                 alt="Image de produit : {{ $item->product->title }}"
                                                 class="w-10 h-10 rounded-lg object-cover bg-gray-100 dark:bg-gray-800">
                                            <span class="text-gray-800 dark:text-gray-200 font-medium">
                                                {{ $item->product->title }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic">Produit supprimé</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-center text-gray-600 dark:text-gray-300">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-5 py-3 text-right text-gray-600 dark:text-gray-300">
                                    {{ number_format($item->selling_price, 2) }} DH
                                </td>
                                <td class="px-5 py-3 text-right font-medium text-gray-800 dark:text-gray-100">
                                    {{ number_format($item->total, 2) }} DH
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-gray-100 dark:border-gray-800">
                            <td colspan="3" class="px-5 py-3 text-right text-gray-500 text-sm">Livraison</td>
                            <td class="px-5 py-3 text-right text-gray-800 dark:text-gray-100">
                                {{ number_format($order->shipping_price, 2) }} DH
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-5 py-3 text-right font-semibold text-gray-800 dark:text-gray-100">Total</td>
                            <td class="px-5 py-3 text-right font-bold text-amani text-base">
                                {{ number_format($order->total_price, 2) }} DH
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Colonne droite : client --}}
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-5">
                <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-4">Client</h2>

                @if ($order->customer)
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-amani/10 text-amani flex items-center justify-center font-semibold">
                                {{ strtoupper(substr($order->customer->name, 0, 1)) }}
                            </div>
                            <p class="font-medium text-gray-800 dark:text-gray-200">
                                {{ $order->customer->name }}
                            </p>
                        </div>

                        <div class="pt-2 space-y-2">
                            <p class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                <i class="fa-solid fa-phone text-gray-400 w-4"></i>
                                {{ $order->customer->phone }}
                            </p>

                            @if ($order->customer->instagram)
                                <p class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <i class="fa-brands fa-instagram text-gray-400 w-4"></i>
                                    {{ $order->customer->instagram }}
                                </p>
                            @endif

                            <p class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                <i class="fa-solid fa-location-dot text-gray-400 w-4"></i>
                                {{ $order->customer->city }}
                            </p>

                            <p class="text-gray-600 dark:text-gray-300 pl-6">
                                {{ $order->customer->address }}
                            </p>
                        </div>
                    </div>
                @else
                    <p class="text-gray-400 italic text-sm">Client supprimé</p>
                @endif
            </div>
        </div>
    </div>
    @can('update',$order)
    <x-modals.confirm-delete id="deleteOrderModal" title="Supprimer la commande" message="Vous voulez vraiment supprimer cette commande ?" />
    <x-modals.confirm-delete id="deleteShipmentModal" title="Retirer de Sendit" message="Vous voulez vraiment retirer cette commande de Sendit ?" action="Retirer" />   
    @endcan

</x-admin.layouts.app>