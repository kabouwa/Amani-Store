@props(['id', 'title' => 'Confirmer la suppression', 'message' => 'Êtes-vous sûr de vouloir supprimer cet élément ?'])

<div id={{ $id }} class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div data-modal-box class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6 scale-95 opacity-0 transition-all duration-200">

        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
        </div>

        <p class="text-sm text-gray-600 mb-6">{{ $message }}</p>

        <div class="flex justify-end gap-3">
            <button type="button" class="js-modal-cancel px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 transition cursor-pointer">
                Annuler
            </button>
            <form id={{ $id . "Form"}} method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition cursor-pointer">
                    Supprimer
                </button>
            </form>
        </div>

    </div>
</div>