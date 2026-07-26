<x-admin.layouts.app title="Modifier une commande">
    <x-slot:heading>
        <i class="fa-solid fa-pen w-4 text-center"></i> Modifier les informations du client
    </x-slot:heading>

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
    </div>

    @error('name')
        <x-alert>{{ $message }}</x-alert>
    @enderror
    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2">
            <form action="{{ route('admin.orders.update', $order->code) }}" method="POST" novalidate
                  class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                @csrf
                @method('PUT')

                <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                    Informations client
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $order->customer->name) }}" required
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                      focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                        @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Téléphone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $order->customer->phone) }}" required placeholder="0XXXXXXXXX"
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                      focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                        @error('phone')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Instagram</label>
                        <div class="relative">
                            <i class="fa-brands fa-instagram absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="instagram" id="instagram" value="{{ old('instagram', $order->customer->instagram) }}"
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 pl-9 pr-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                        </div>
                        @error('instagram')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="relative">
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ville</label>

                        <select name="district_id" id="city" required
                                class="w-full appearance-none rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 pr-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                    focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition cursor-pointer">
                            <option value="" disabled {{ old('district_id', $order->customer->district_id) ? '' : 'selected' }}>Choisir la ville</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city['id'] }}" {{ old('district_id', $order->customer->district_id) == $city['id'] ? 'selected' : '' }}>
                                    {{ $city['name'] }} | {{ $city['arabic_name'] }}
                                </option>
                            @endforeach
                        </select>

                        <div class="absolute top-9 right-1.5 pointer-events-none text-gray-400  dark:text-gray-100 text-sm bg-white dark:bg-gray-800 z-50 px-1.5">
                            <i class="fa-solid fa-angle-down"></i>
                        </div>

                        @error('district_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $order->customer->address) }}"
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                      focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                        @error('address')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                </div>

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
                    <a href="{{ route('admin.orders.index') }}"
                       class="cursor-pointer px-5 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        Annuler
                    </a>
                    <button type="submit"
                            class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2">
                        <i class="fa-solid fa-check"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>

        {{-- Right: order summary (read-only) --}}
        <div class="space-y-6">

            {{-- Status + totals --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Commande</h2>
                    <x-admin.order-status :status="$order->status" />
                </div>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Agence</span>
                        <span class="font-medium text-gray-800 dark:text-gray-100">{{ $order->shipping_agency }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Livraison</span>
                        <span class="font-medium text-gray-800 dark:text-gray-100">{{ number_format($order->shipping_price, 2) }} DH</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-100 dark:border-gray-800 text-base">
                        <span class="font-semibold text-gray-700 dark:text-gray-200">Total</span>
                        <span class="font-bold text-amani">{{ number_format($order->total_price, 2) }} DH</span>
                    </div>
                </div>

                @if($order->note)
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <p class="text-xs text-gray-400 mb-1">Note</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->note }}</p>
                    </div>
                @endif
            </div>

            {{-- Articles (read-only) --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                    Articles ({{ $order->items->sum('quantity') }})
                </h2>

                <div class="space-y-3">
                    @foreach ($order->items as $item)
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 rounded-lg bg-gray-50 dark:bg-gray-800 overflow-hidden shrink-0">
                                @if($item->product->primaryImage)
                                    <img src="{{ asset('storage/' . $item->product->primaryImage->image) }}"
                                         alt="{{ $item->product->title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate">{{ $item->product->title }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ $item->quantity }} × {{ number_format($item->selling_price, 2) }} DH
                                </p>
                            </div>

                            <span class="text-sm font-semibold text-gray-800 dark:text-gray-100 shrink-0">
                                {{ number_format($item->quantity * $item->selling_price, 2) }} DH
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    @push('scripts')
        @vite('resources/js/select-search.js')
    @endpush
</x-admin.layouts.app>