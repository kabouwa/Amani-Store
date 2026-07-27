<x-admin.layouts.app title="Ramassage">
    <x-slot:heading>
        <i class="fa-solid fa-truck-fast w-4 text-center"></i> Ramassage
    </x-slot:heading>

    @if($errors->any())
        <x-alert>{{ $errors->first() }}</x-alert>
    @endif
    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif
    @if(session('error'))
        <x-alert >{{ session('error') }}</x-alert>
    @endif

    {{-- New pickup selection --}}
    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
        <i class="fa-solid fa-plus text-amani mr-1"></i> Nouveau ramassage
    </h2>

    @if(count($orders))

        <div class="flex items-center justify-between mb-6 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm px-5 py-3">
            <label class="flex items-center gap-2.5 cursor-pointer group">
                <input type="checkbox" id="selectAll" class="sr-only">

                <span class="w-5 h-5 rounded-md border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center
                            transition-all duration-200 group-has-[:checked]:bg-amani group-has-[:checked]:border-amani">
                    <i class="fa-solid fa-check text-white text-[10px] opacity-0 group-has-[:checked]:opacity-100 transition-opacity duration-200"></i>
                </span>

                <span class="text-sm text-gray-600 dark:text-gray-300">Tout sélectionner</span>
            </label>

            <span id="selectedCount" class="text-sm text-gray-400">0 sélectionnée(s)</span>
        </div>

        <form action="{{ route('admin.pickups.store') }}" method="POST" id="pickupForm">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                @foreach ($orders as $order)
                    <label class="js-pickup-card group relative block bg-white dark:bg-gray-900 rounded-xl border-2 border-gray-200 dark:border-gray-800
                                  shadow-sm p-5 cursor-pointer transition-all duration-200
                                  has-[:checked]:border-amani has-[:checked]:bg-amani/5 dark:has-[:checked]:bg-amani/10">

                        <input type="checkbox" name="sendit_codes[]" value="{{ $order->sendit_code }}" class="sr-only js-pickup-checkbox">

                        <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center
                                    transition-all duration-200 group-has-[:checked]:bg-amani group-has-[:checked]:border-amani">
                            <i class="fa-solid fa-check text-white text-xs opacity-0 group-has-[:checked]:opacity-100 transition-opacity duration-200"></i>
                        </div>

                        <p class="text-xs text-gray-400 mb-1">{{ $order->code }}</p>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-3 pr-8">{{ $order->customer->name }}</h3>

                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1.5">
                            <p><i class="fa-solid fa-phone w-4 text-gray-400 dark:text-gray-500"></i> {{ $order->customer->phone }}</p>
                            <p><i class="fa-solid fa-location-dot w-4 text-gray-400 dark:text-gray-500"></i> {{ $order->customer->city }}</p>
                            <p><i class="fa-solid fa-box w-4 text-gray-400 dark:text-gray-500"></i> {{ $order->items->sum('quantity') }} article(s)</p>
                        </div>

                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100 dark:border-gray-800">
                            <span class="text-xs text-gray-400">{{ $order->sendit_code }}</span>
                            <span class="font-bold text-gray-800 dark:text-gray-100">{{ number_format($order->total_price, 2) }} DH</span>
                        </div>

                    </label>
                @endforeach
            </div>

            <div class="sticky bottom-4 flex justify-end mb-10">
                <button type="submit" id="pickupSubmit" disabled
                        class="cursor-pointer bg-amani hover:bg-amani-dark disabled:bg-gray-300 dark:disabled:bg-gray-700 disabled:cursor-not-allowed
                               text-white px-6 py-3 rounded-xl shadow-lg transition flex items-center gap-2 font-medium">
                    <i class="fa-solid fa-truck-fast"></i>
                    Confirmer le ramassage (<span id="submitCount">0</span>)
                </button>
            </div>
        </form>

    @else
        <div class="flex flex-col items-center justify-center py-12 text-center mb-10 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800">
            <div class="w-14 h-14 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                <i class="fa-solid fa-truck text-gray-300 dark:text-gray-600 text-xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 font-medium">Aucune commande à ramasser</p>
        </div>
    @endif

    {{-- Existing pickups --}}
    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
        <i class="fa-solid fa-clipboard-list text-amani mr-1"></i> Ramassages effectués
    </h2>

    @if(count($pickups))

        {{-- Desktop / tablet table --}}
        <div class="hidden md:block bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-left text-gray-600 dark:text-gray-300">
                        <th class="px-5 py-3 font-semibold">Code</th>
                        <th class="px-5 py-3 font-semibold">Contact</th>
                        <th class="px-5 py-3 font-semibold">Téléphone</th>
                        <th class="px-5 py-3 font-semibold">Ville</th>
                        <th class="px-5 py-3 font-semibold">Adresse</th>
                        <th class="px-5 py-3 font-semibold">Commandes</th>
                        <th class="px-5 py-3 font-semibold">Statut</th>
                        <th class="px-5 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($pickups as $pickup)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                            <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $pickup->code }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800 dark:text-gray-100">{{ $pickup->name }}</td>
                            <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $pickup->phone }}</td>
                            <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $pickup->district['name'] ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $pickup->address }}</td>
                            <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ count($pickup->deliveries) }}</td>
                            <td class="px-5 py-3">
                                <x-admin.pickup-status :status="$pickup->status" />
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex justify-end gap-2">
                                    @if(in_array($pickup->status, ['SCHEDULED', 'PENDING']))
                                        <button type="button" class="js-delete-btn cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition"
                                                data-action="{{ route('admin.pickups.destroy', $pickup->code) }}"
                                                data-modal="deletePickupModal">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile card list --}}
        <div class="md:hidden space-y-3">
            @foreach ($pickups as $pickup)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <span class="font-semibold text-gray-800 dark:text-gray-100 block">{{ $pickup->name }}</span>
                            <span class="text-xs text-gray-400">{{ $pickup->code }}</span>
                        </div>
                        <x-admin.pickup-status :status="$pickup->status" />
                    </div>

                    <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1 mb-3">
                        <p><i class="fa-solid fa-phone w-4 text-gray-400"></i> {{ $pickup->phone }}</p>
                        <p><i class="fa-solid fa-location-dot w-4 text-gray-400"></i> {{ $pickup->district['name'] ?? '—' }}</p>
                        <p><i class="fa-solid fa-map w-4 text-gray-400"></i> {{ $pickup->address }}</p>
                        <p><i class="fa-solid fa-box w-4 text-gray-400"></i> {{ count($pickup->deliveries) }} commande(s)</p>
                    </div>

                    @if(in_array($pickup->status, ['SCHEDULED', 'PENDING']))
                        <div class="flex justify-end pt-3 border-t border-gray-100 dark:border-gray-800">
                            <button type="button" class="js-delete-btn cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition"
                                    data-action="{{ route('admin.pickups.destroy', $pickup->code) }}"
                                    data-modal="deletePickupModal">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    @else
        <div class="flex flex-col items-center justify-center py-12 text-center bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800">
            <div class="w-14 h-14 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                <i class="fa-solid fa-clipboard text-gray-300 dark:text-gray-600 text-xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 font-medium">Aucun ramassage effectué</p>
        </div>
    @endif

    <x-modals.confirm-delete id="deletePickupModal" title="Annuler le ramassage" message="Voulez-vous vraiment annuler ce ramassage ?" />

    @push('scripts')
        @vite('resources/js/admin/pickups.js')
    @endpush
</x-admin.layouts.app>