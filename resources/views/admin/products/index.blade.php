<x-admin.layouts.app title="Gestion des produits">
    <x-slot:heading>
        <i class="fa-solid fa-bag-shopping w-4 text-center"></i> Gestion des produits
    </x-slot:heading>

    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif
    <div class="mb-2 flex flex-col md:flex-row md:items-center md:justify-between">
        <a href="{{ route('admin.products.create') }}"
            class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-4 py-3 rounded-lg transition
                flex items-center justify-center gap-2 text-sm font-medium w-full md:w-auto md:ml-auto shrink-0">
            <i class="fa-solid fa-plus"></i> Ajouter un produit
        </a>
    </div>

    {{-- Toolbar --}}
    <x-product-toolbar :categories="$categories" />        
       

    <div class="text-gray-400 my-3">
        <p>
            {{ count($products) }} {{ count($products) > 1 ? 'produits ont été trouvés.' : 'produits a été trouvé.' }}
        </p>
    </div>

    {{-- Grid --}}
    @if(count($products))
        <div id="productsGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-5">
            @foreach ($products as $p)
                <x-admin.product-card :product="$p" />
            @endforeach
        </div>
        <x-modals.confirm-delete id="deleteModal"
                       message="Êtes-vous sûr de vouloir supprimer ce produit ?" />
    @else
        {{-- Empty state --}}
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                <i class="fa-solid fa-bag-shopping text-gray-300 text-2xl"></i>
            </div>
            <p class="text-gray-500 font-medium">Aucun produit pour le moment</p>
            <p class="text-sm text-gray-400 mt-1">Commencez par ajouter votre premier produit.</p>
            <a href="{{ route('admin.products.create') }}"
               class="cursor-pointer mt-4 bg-amani hover:bg-amani-dark text-white px-5 py-2.5 rounded-lg transition text-sm font-medium">
                <i class="fa-solid fa-plus mr-1"></i> Ajouter un produit
            </a>
        </div>
    @endif

    @push('scripts')
        @vite('resources/js/products/toolbar.js')
        @vite('resources/js/products/carousel.js')
    @endpush
</x-admin.layouts.app>