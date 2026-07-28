@props([])

<aside id="sidebar"
       class="fixed top-16 left-0 bottom-0 w-72 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 z-30
              transform -translate-x-full md:translate-x-0 transition-all duration-300 overflow-hidden
              flex flex-col align-center justify-between">

    <nav class="p-4 space-y-1">

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.dashboard') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-chart-line w-5 text-xl text-center shrink-0"></i>
            <span class="sidebar-label whitespace-nowrap">Tableau de bord</span>
        </a>

        <a href="{{ route('admin.orders.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.orders.index') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-box w-5 text-xl text-center shrink-0"></i>
            <span class="sidebar-label whitespace-nowrap">Gestion des Commandes</span>
        </a>

        <a href="{{ route('admin.pickups.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.pickups.index') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-truck-fast w-5 text-xl text-center shrink-0"></i>
            <span class="sidebar-label whitespace-nowrap">Demander un ramassage</span>
        </a>

        <a href="{{ route('admin.products.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.edit') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-bag-shopping w-5 text-xl text-center shrink-0"></i>
            <span class="sidebar-label whitespace-nowrap">Gestion des produits</span>
        </a>

        <a href="{{ route('admin.products.create') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.products.create') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-plus w-5 text-xl text-center shrink-0"></i>
            <span class="sidebar-label whitespace-nowrap">Ajouter un produit</span>
        </a>

        <a href="{{ route('admin.categories.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.categories.index') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-tags w-5 text-xl text-center shrink-0"></i>
            <span class="sidebar-label whitespace-nowrap">Gestion des catégories</span>
        </a>

        <a href="{{ route('admin.customers.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.customers.index') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-users w-5 text-xl text-center shrink-0"></i>
            <span class="sidebar-label whitespace-nowrap">Liste des Clients</span>
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.users.index') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-user-shield w-5 text-xl text-center shrink-0"></i>
            <span class="sidebar-label whitespace-nowrap">Équipe de travail</span>
        </a>

        <a href="{{ route('admin.users.create') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.users.create') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-user-plus w-5 text-xl text-center shrink-0"></i>
            <span class="sidebar-label whitespace-nowrap">Ajouter un administrateur</span>
        </a>
    </nav>

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
<div id="sidebarOverlay" class="fixed inset-0 bg-black/30 dark:bg-black/60 z-20 hidden md:hidden"></div>

<x-modals.confirm-delete id="logoutModal"
                          title="Déconnexion"
                          action="Se déconnecter"
                          message="Êtes-vous sûr de vouloir vous déconnecter ?" />