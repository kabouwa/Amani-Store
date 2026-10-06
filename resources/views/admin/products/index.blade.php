<x-admin.layouts.app title="Gestion des produits">
    <x-slot:heading>
        <i class="fa-solid fa-bag-shopping w-4 text-center"></i> Gestion des produits
    </x-slot:heading>

    <x-slot:headingBtn>
        <a href={{ route('admin.products.create') }}
            class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-4 py-3 rounded-lg transition
                flex items-center justify-center gap-2 text-sm font-medium w-full md:w-auto md:ml-auto shrink-0">
            <i class="fa-solid fa-plus"></i> Ajouter un produit
        </a>
    </x-slot:headingBtn>

    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif

    {{-- Toolbar --}}
    <x-products-toolbar :categories="$categories" />


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

        <div class="my-4">
            {{ $products->links() }}
        </div>

        <x-modals.confirm-delete id="deleteModal"
                       message="Êtes-vous sûr de vouloir supprimer ce produit ?" />
    @else
        {{-- Empty state --}}
        <x-admin.resource-not-found icon="fa-box-open" title="Aucun produit trouvé"
            :description="request()->has('search') ? 'Essayez de modifier vos filtres ou votre recherche.' : 'Vous n\'avez pas encore créé de produit.'" />
    @endif



    @push('scripts')
        @vite('resources/js/products/carousel.js')
    @endpush
</x-admin.layouts.app>
