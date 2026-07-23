@props([])

<aside id="sidebar"
       class="fixed top-16 left-0 bottom-0 w-64 bg-white border-r border-gray-200 z-30
              transform -translate-x-full md:translate-x-0 transition-transform duration-300 overflow-y-auto
              flex flex-col align-center justify-between">

    <nav class="p-4 space-y-1">

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-amani/10 hover:text-amani transition
                {{ request()->routeIs('admin.dashboard') ? 'bg-amani/10 text-amani font-semibold' : '' }}">
            <i class="fa-solid fa-chart-line w-4 text-center"></i> Tableau de bord
        </a>

        <a href="{{ route('admin.dashboard') }}"
        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-amani/10 hover:text-amani transition
                {{ request()->routeIs('admin.orders.index') ? 'bg-amani/10 text-amani font-semibold' : '' }}">
            <i class="fa-solid fa-box w-4 text-center"></i> Commandes
        </a>

        <a href="{{ route('admin.products.index') }}"
        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-amani/10 hover:text-amani transition
                {{ request()->routeIs('admin.products.index') ? 'bg-amani/10 text-amani font-semibold' : '' }}">
            <i class="fa-solid fa-bag-shopping w-4 text-center"></i> Produits
        </a>

        <a href="{{ route('admin.categories.index') }}"
            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-amani/10 hover:text-amani transition
                    {{ request()->routeIs('admin.categories.index') ? 'bg-amani/10 text-amani font-semibold' : '' }}">
                <i class="fa-solid fa-tags w-4 text-center"></i> Catégories
            </a>

        <a href="{{ route('admin.customers.index') }}"
        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-amani/10 hover:text-amani transition
                {{ request()->routeIs('admin.customers.index') ? 'bg-amani/10 text-amani font-semibold' : '' }}">
            <i class="fa-solid fa-users w-4 text-center"></i> Clients
        </a>




    </nav>
    <div class="aside-bottom p-4 space-y-1">
        <div class="line border-t-1 border-gray-200"></div>

        <a href="{{ route('admin.dashboard') }}"
        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-amani/10 hover:text-amani transition">
            <i class="fa-solid fa-gear w-4 text-center"></i> Paramètres
        </a>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-red-500 hover:bg-red-50 hover:text-red-600 transition cursor-pointer">
                <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Déconnexion
            </button>
        </form>
    </div>
</aside>

{{-- Mobile overlay --}}
<div id="sidebarOverlay" class="fixed inset-0 bg-black/30 z-20 hidden md:hidden"></div>
