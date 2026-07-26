@props([
    'id',
    'title' => 'Confirmer la suppression',
    'action' => 'Supprimer',
    'message' => 'Êtes-vous sûr de vouloir supprimer cet élément ?',
    'deleteAccount' => false,
])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 dark:bg-black/70">
    <div data-modal-box class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg w-full max-w-xs p-6 scale-95 opacity-0 transition-all duration-200 md:max-w-sm">

        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $title }}</h3>
        </div>

        <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">{{ $message }}</p>

        <form id="{{ $id }}Form" method="POST" action="" novalidate>
            @csrf
            @method('DELETE')

            @if ($deleteAccount)
                <div class="mb-6">
                    <label for="delete_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mot de passe actuel</label>
                    <div class="relative">
                        <input type="password" name="delete_password" id="delete_password" required
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 pr-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                      focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                        <button type="button" class="js-toggle-password cursor-pointer absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-amani"
                                data-target="delete_password">
                            <i class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('delete_password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
            @endif

            <div class="flex justify-end gap-3">
                <button type="button"
                        class="js-modal-cancel px-4 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition cursor-pointer">
                    <i class="fa-solid fa-xmark"></i> Annuler
                </button>

                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition cursor-pointer">
                    <i class="fa-solid fa-trash"></i> {{ $action }}
                </button>
            </div>
        </form>

    </div>
</div>