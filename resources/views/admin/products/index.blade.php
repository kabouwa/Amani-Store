<x-admin.layouts.app
    title="Gestion du produits"
>
    <x-slot:heading><i class="fa-solid fa-bag-shopping w-4 text-center"></i> Gestion du produits</x-slot:heading>


    @foreach ($products as $p)
        <p>{{ $p->title }}</p>
        <p>{{ $p->description }}</p>
        <p>{{ $p->purchase_price }}</p>
        <p>{{ $p->selling_price }}</p>
    @endforeach

</x-admin.layouts.app>