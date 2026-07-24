@props([])

<aside id="sidebar"
       class="fixed top-16 left-0 bottom-0 w-70 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 z-30
              transform -translate-x-full md:translate-x-0 transition-transform duration-300 overflow-y-auto
              flex flex-col align-center justify-between">

    <nav class="p-4 space-y-1">

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.dashboard') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-chart-line w-4 text-center"></i> Tableau de bord
        </a>

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.orders.index') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-box w-4 text-center"></i> Gestion des Commandes
        </a>

        <a href="{{ route('admin.products.create') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.products.create') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-plus w-4 text-center"></i> Ajouter un produit
        </a>

        <a href="{{ route('admin.products.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.edit') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-bag-shopping w-4 text-center"></i> Gestion des produits
        </a>

        <a href="{{ route('admin.categories.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.categories.index') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-tags w-4 text-center"></i> Gestion des catégories
        </a>

        <a href="{{ route('admin.customers.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition
                {{ request()->routeIs('admin.customers.index') ? 'bg-amani/10 dark:bg-amani text-amani dark:text-white font-semibold' : '' }}">
            <i class="fa-solid fa-users w-4 text-center"></i> Liste des Clients
        </a>

    </nav>

    <div class="aside-bottom p-4 space-y-1">
        <div class="border-t border-gray-100 my-3 dark:border-gray-700"></div>
        
        <button type="button" id="themeToggle"
            class="cursor-pointer w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300
               hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition">
            <span class="flex items-center gap-3">
                <i class="fa-solid fa-moon w-4 text-center" id="themeIcon"></i> Mode sombre
            </span>

            <div class="relative w-9 h-5 bg-gray-200 dark:bg-gray-700 rounded-full transition-colors duration-200" id="themeSwitch">
                <div class="absolute top-0.5 left-0.5 bg-white dark:bg-gray-200 rounded-full h-4 w-4 transition-all duration-200" id="themeKnob"></div>
            </div>
        </button>

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amani/10 dark:hover:bg-amani hover:text-amani dark:hover:text-white transition">
            <i class="fa-solid fa-gear w-4 text-center"></i> Paramètres
        </a>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-600 dark:hover:text-white transition cursor-pointer">
                <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Déconnexion
            </button>
        </form>
    </div>
</aside>

{{-- Mobile overlay --}}
<div id="sidebarOverlay" class="fixed inset-0 bg-black/30 dark:bg-black/60 z-20 hidden md:hidden"></div>