@props(['id' => 'orderDetailsModal'])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div data-modal-box
         class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl w-full max-w-2xl h-[90vh] flex flex-col
                scale-95 opacity-0 transition-all duration-200">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 shrink-0">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                <i class="fa-solid fa-receipt text-amani mr-2"></i>
                <span id="orderDetailsCode">Commande</span>
            </h3>
            <button type="button" class="js-modal-cancel cursor-pointer text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Body (scrollable, populated by JS) --}}
        <div id="orderDetailsBody" class="flex-1 overflow-y-auto px-6 py-5">
            {{-- Loading skeleton, swapped for real content --}}
            <div class="js-order-loading flex items-center justify-center h-full text-gray-400">
                <i class="fa-solid fa-spinner fa-spin text-2xl"></i>
            </div>
        </div>

    </div>
</div>