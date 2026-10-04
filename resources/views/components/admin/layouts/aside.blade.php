@props([])

@php
    $links = [
        ['route' => 'admin.dashboard',        'label' => 'Tableau de bord',            'icon' => 'fa-chart-line',   'active' => 'admin.dashboard'],
        ['route' => 'admin.orders.index',     'label' => 'Gestion des commandes',      'icon' => 'fa-box',          'active' => 'admin.orders.index'],
        ['route' => 'admin.orders.create',    'label' => 'Créer une commande',         'icon' => 'fa-cart-plus',    'active' => 'admin.orders.create'],
        ['route' => 'admin.pickups.index',    'label' => 'Demander un ramassage',      'icon' => 'fa-truck-fast',   'active' => 'admin.pickups.index'],
        ['route' => 'admin.products.index',   'label' => 'Gestion des produits',       'icon' => 'fa-bag-shopping', 'active' => 'admin.products.*'],
        ['route' => 'admin.products.create',  'label' => 'Ajouter un produit',         'icon' => 'fa-plus',         'active' => 'admin.products.create'],
        ['route' => 'admin.categories.index', 'label' => 'Gestion des catégories',     'icon' => 'fa-tags',         'active' => 'admin.categories.index'],
        ['route' => 'admin.customers.index',  'label' => 'Liste des clients',          'icon' => 'fa-users',        'active' => 'admin.customers.index'],
        ['route' => 'admin.suppliers.index',  'label' => 'Gestion des fournisseurs',   'icon' => 'fa-building',     'active' => 'admin.suppliers.*'],
        ['route' => 'admin.users.index',      'label' => 'Équipe de travail',          'icon' => 'fa-user-shield',  'active' => 'admin.users.*'],
        ['route' => 'admin.users.create',     'label' => 'Ajouter un administrateur',  'icon' => 'fa-user-plus',    'active' => 'admin.users.create'],
    ];
@endphp

<aside id="sidebar"
    class="fixed top-16 left-0 bottom-0 w-72 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 z-50
        transform -translate-x-full md:translate-x-0 transition-all duration-300 overflow-hidden flex flex-col align-center justify-between">

    <nav class="p-4 space-y-1 overflow-y-auto md:overflow-hidden">
        @foreach ($links as $link)
            <a href="{{ route($link['route']) }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                    {{ request()->routeIs($link['active']) ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">

                <i class="fa-solid {{ $link['icon'] }} w-5 text-xl text-center shrink-0"></i>

                <span class="sidebar-label whitespace-nowrap">
                    {{ $link['label'] }}
                </span>
            </a>
        @endforeach
    </nav>


    {{-- Bottom Link --}}
    <div class="aside-bottom p-4 space-y-1">
        <div class="border-t border-gray-100 my-3 dark:border-gray-700"></div>

        <button type="button" id="themeToggle"
            class="cursor-pointer w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300
               hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition">
            <span class="flex items-center gap-3">
                <i class="fa-solid fa-moon w-5 text-xl text-center shrink-0" id="themeIcon"></i>
                <span class="sidebar-label whitespace-nowrap">Mode sombre</span>
            </span>

            <div class="sidebar-label relative w-9 h-5 bg-gray-200 dark:bg-gray-700 rounded-full transition-colors duration-200 shrink-0" id="themeSwitch">
                <div class="absolute top-0.5 left-0.5 bg-white dark:bg-gray-200 rounded-full h-4 w-4 transition-all duration-200" id="themeKnob"></div>
            </div>
        </button>

        <a href="{{ route('admin.users.edit', auth()->user()->slug ) }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition">
            <i class="fa-solid fa-gear w-5 text-xl text-center shrink-0"></i>
            <span class="sidebar-label whitespace-nowrap">Paramètres du compte</span>
        </a>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            @method('DELETE')
            <button type="button"
                    class="js-delete-btn w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-600 dark:hover:text-white transition cursor-pointer"
                    data-action="{{ route('admin.logout') }}"
                    data-modal="logoutModal">
                <i class="fa-solid fa-right-from-bracket w-5 text-xl text-center shrink-0"></i>
                <span class="sidebar-label whitespace-nowrap">Déconnexion</span>
            </button>
        </form>
    </div>
</aside>

{{-- Mobile overlay --}}
<div id="sidebarOverlay" class="fixed inset-0 bg-black/30 dark:bg-black/60 z-40 hidden md:hidden"></div>

<x-modals.confirm-delete id="logoutModal"
    title="Déconnexion"
    action="Se déconnecter"
    message="Êtes-vous sûr de vouloir vous déconnecter ?" />
