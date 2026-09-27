<x-layouts.app title="Session expirée">

    <div class="min-h-[70vh] flex items-center justify-center px-6">
        <div class="text-center max-w-md">

            <div class="w-20 h-20 rounded-full bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-clock-rotate-left text-3xl"></i>
            </div>

            <p class="text-6xl font-bold text-gray-200 dark:text-gray-800 mb-2">419</p>
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">Session expirée</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">
                Votre session a expiré. Veuillez réessayer.
            </p>

            <button onclick="history.back()"
                    class="cursor-pointer inline-flex items-center gap-2 bg-amani hover:bg-amani-dark text-white font-semibold px-6 py-2.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md hover:shadow-amani/30">
                <i class="fa-solid fa-rotate-right"></i> Réessayer
            </button>

        </div>
    </div>

</x-layouts.app>
