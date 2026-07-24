<x-admin.layouts.app title="Ajouter un produit">
    <x-slot:heading>
        <i class="fa-solid fa-bag-shopping w-4 text-center"></i> Ajouter un produit
    </x-slot:heading>

    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif

    <x-admin.forms.product :categories="$categories" />


    @push('scripts')
        @vite('resources/js/admin/product-images.js')
    @endpush

</x-admin.layouts.app>
