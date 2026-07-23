<x-admin.layouts.app title="Liste des clients">
    <x-slot:heading>
        <i class="fa-solid fa-users w-4 text-center"></i> Gestion des clients
    </x-slot:heading>

    {{-- Messages --}}
    @error('title')
        <x-alert>{{ $message }}</x-alert>
    @enderror
    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif

    {{-- Search for customer --}}
    <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-3 mb-8 w-full md:w-auto md:max-w-md" novalidate>
        <input type="search" name="search" placeholder="Chercher client..." required
               class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900
                      focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition" value={{ old('search') }}>
        <button type="submit"
                class="bg-amani hover:bg-amani-dark text-white px-4 py-2.5 rounded-lg transition flex items-center gap-2 cursor-pointer">
            <i class="fa-solid fa-plus"></i> Chercher
        </button>
        @if (request()->has('search'))
            <a href="{{ route('admin.customers.index') }}"
                class="border-2 border-amani text-amani hover:bg-amani-dark hover:text-white px-4 py-2.5 rounded-lg transition flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-rotate-right"></i>
            </a>
        @endif
    </form>

    {{-- Desktop / tablet table --}}
    <div class="hidden md:block bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-left text-gray-600">
                    <th class="px-5 py-3 font-semibold">Nom</th>
                    <th class="px-5 py-3 font-semibold">Téléphone</th>
                    <th class="px-5 py-3 font-semibold">Instagram</th>
                    <th class="px-5 py-3 font-semibold">Adresse</th>
                    <th class="px-5 py-3 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($customers as $c)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $c->name }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $c->phone }}</td>
                        <td class="px-5 py-3 text-gray-600">
                            @if($c->instagram)
                                <a href="https://instagram.com/{{ ltrim($c->instagram, '@') }}" target="_blank"
                                   class="text-amani hover:underline">
                                    <i class="fa-brands fa-instagram"></i> {{ $c->instagram }}
                                </a>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $c->address }}</td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-2">
                                <button type="button"
                                        class="cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 hover:text-amani hover:bg-amani/10 transition">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button type="button" class="js-delete-btn cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 hover:text-red-600 hover:bg-red-50 transition"
                                        data-action="{{ route('admin.customers.destroy', $c->id) }}">
                                    <i class="fa-solid fa-trash"></i>
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
        @foreach ($customers as $c)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                <div class="flex items-start justify-between mb-2">
                    <span class="font-semibold text-gray-800">{{ $c->name }}</span>
                    <div class="flex gap-2">
                        <button type="button" class="cursor-pointer w-7 h-7 flex items-center justify-center rounded-full text-gray-500 hover:text-amani hover:bg-amani/10 transition">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </button>
                        <button type="button" class="js-delete-btn cursor-pointer w-7 h-7 flex items-center justify-center rounded-full text-gray-500 hover:text-red-600 hover:bg-red-50 transition"
                                data-action={{ route('admin.customers.destroy', $c->id) }}>
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="text-sm text-gray-600 space-y-1">
                    <p><i class="fa-solid fa-phone w-4 text-gray-400"></i> {{ $c->phone }}</p>
                    @if($c->instagram)
                        <p><i class="fa-brands fa-instagram w-4 text-gray-400"></i> {{ $c->instagram }}</p>
                    @endif
                    @if($c->address)
                        <p><i class="fa-solid fa-location-dot w-4 text-gray-400"></i> {{ $c->address }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-gray-400 my-3">
        <p>
            {{ count($customers) }} {{ count($customers) > 1 ? 'clients ont été trouvés.' : 'client a été trouvé.' }}
        </p>
    </div>

    <x-modals.confirm-delete id="deleteModal"
                       message="Êtes-vous sûr de vouloir supprimer ce client avec sa commande ?" />

</x-admin.layouts.app>
