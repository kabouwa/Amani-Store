<x-admin.layouts.app title="Ajouter un fournisseur">
    <x-slot:heading>
        <i class="fa-solid fa-building w-4 text-center"></i> Ajouter un fournisseur
    </x-slot:heading>

    @if($errors->any())
        <x-alert classes="max-w-4xl mx-auto" >Veuillez corriger les erreurs ci-dessous.</x-alert>
    @endif

    <x-admin.forms.supplier :supplier="$supplier" action="{{ route('admin.suppliers.store') }}" />

</x-admin.layouts.app>
