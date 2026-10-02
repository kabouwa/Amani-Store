<x-admin.layouts.app title="Gestion des fournisseurs">
    <x-slot:heading>
        <i class="fa-solid fa-building w-4 text-center"></i> Gestion des fournisseurs
    </x-slot:heading>

    <x-slot:headingBtn>
        <a href="{{ route('admin.suppliers.create') }}"
               class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-4 py-2.5 rounded-lg transition
                  flex items-center justify-center gap-2 text-sm font-medium">
            <i class="fa-solid fa-plus"></i> Ajouter un fournisseur
        </a>
    </x-slot:headingBtn>

    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif



    @if(count($suppliers))
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach ($suppliers as $supplier)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">

                    {{-- Image --}}
                    <div class="h-60 bg-gray-50 dark:bg-gray-800 overflow-hidden">
                        @if ($supplier->image)
                            <img src="{{ route('admin.storage.supplier', $supplier) }}"
                                 alt="{{ $supplier->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                <i class="fa-solid fa-building text-3xl"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-5">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-100">{{ $supplier->name }}</h3>

                            <div class="flex gap-1.5 shrink-0">
                                <a href="{{ route('admin.suppliers.edit', $supplier) }}"
                                   class="cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-amani hover:bg-amani/10 transition">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <button type="button" class="js-delete-btn cursor-pointer w-8 h-8 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition"
                                        data-action="{{ route('admin.suppliers.destroy', $supplier) }}"
                                        data-modal="deleteSupplierModal">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                            <p><i class="fa-solid fa-phone w-4 text-gray-400 dark:text-gray-500"></i> {{ $supplier->phone }}</p>

                            @if ($supplier->address)
                                <p><i class="fa-solid fa-location-dot w-4 text-gray-400 dark:text-gray-500"></i> {{ $supplier->address }}</p>
                            @endif

                            @if ($supplier->note)
                                <p class="pt-2 border-t border-gray-100 dark:border-gray-800 text-gray-500 dark:text-gray-400">
                                    {{ $supplier->note }}
                                </p>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                <i class="fa-solid fa-truck-field text-gray-300 dark:text-gray-600 text-2xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 font-medium">Aucun fournisseur pour le moment</p>
        </div>
    @endif

    <x-modals.confirm-delete id="deleteSupplierModal" title="Supprimer le fournisseur" message="Vous voulez vraiment supprimer ce fournisseur ?" />

</x-admin.layouts.app>
