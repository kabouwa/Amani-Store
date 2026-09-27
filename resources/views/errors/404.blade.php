<x-layouts.app title="Page introuvable">

    <div class="min-h-[70vh] flex items-center justify-center px-6">
        <div class="text-center max-w-md">

            <div class="w-20 h-20 rounded-full bg-amani/10 text-amani flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-compass text-3xl"></i>
            </div>

            <p class="text-6xl font-bold text-gray-200 dark:text-gray-800 mb-2">404</p>
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">Page introuvable</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">
                La page que vous cherchez n'existe pas ou a été déplacée.
            </p>

            <a href="{{ route('home') }}"
               class="cursor-pointer inline-flex items-center gap-2 bg-amani hover:bg-amani-dark text-white font-semibold px-6 py-2.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md hover:shadow-amani/30">
                <i class="fa-solid fa-house"></i> Retour à l'accueil
            </a>

        </div>
    </div>

</x-layouts.app>
