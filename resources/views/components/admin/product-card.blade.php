@props(['product'])

<div class="group relative bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden">

    {{-- Stretched link -> public product page (whole card clickable) --}}
    <a href="{{ route('admin.products.index', $product->slug) }}" class="absolute inset-0 z-0" aria-label="{{ $product->title }}"></a>

    {{-- Admin actions (only visible when authenticated) --}}
    @auth
        <div class="absolute top-2 right-2 z-10 flex gap-1.5">
            <a href="{{ route('admin.products.index', $product->slug) }}"
               class="cursor-pointer w-8 h-8 flex items-center justify-center rounded-full bg-white/95 text-gray-600
                      hover:text-amani hover:bg-white shadow-sm transition">
                <i class="fa-solid fa-pen text-xs"></i>
            </a>
            <button type="button"
                    class="js-delete-btn cursor-pointer w-8 h-8 flex items-center justify-center rounded-full bg-white/95 text-gray-600
                           hover:text-red-600 hover:bg-white shadow-sm transition"
                    data-action="{{ route('admin.products.destroy', $product->slug) }}"
                    data-modal="deleteModal">
                <i class="fa-solid fa-trash text-xs"></i>
            </button>
        </div>
    @endauth

    {{-- Primary image --}}
    <div class="aspect-square bg-gray-50 overflow-hidden">
        @if($product->primaryImage)
            <img src="{{ asset('storage/' . $product->primaryImage->image) }}"
                 alt="{{ $product->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-300">
                <i class="fa-solid fa-image text-3xl"></i>
            </div>
        @endif
    </div>

    {{-- Info --}}
    <div class="p-4 relative z-10 pointer-events-none">
        <p class="text-xs text-amani font-medium mb-1">{{ $product->category->title ?? 'Non Classé' }}</p>
        <h3 class="font-semibold text-gray-800 truncate mb-2">{{ $product->title }}</h3>

        <div class="flex items-center justify-between mb-3">
            <div class="flex items-baseline gap-2">
                <span class="text-lg font-bold text-gray-900">{{ number_format($product->selling_price, 2) }} DH</span>
            </div>
            <span class="text-xs {{ $product->stock > 0 ? 'text-gray-400' : 'text-red-500 font-medium' }}">
                {{ $product->stock > 0 ? $product->stock . ' en stock' : 'Rupture' }}
            </span>
        </div>

        {{-- Active toggle (admin only) --}}
        @auth
            <form action="{{ route('admin.products.toggle', $product->slug) }}" method="POST"
                  class="pointer-events-auto flex items-center justify-between pt-3 border-t border-gray-100">
                @csrf
                @method('PATCH')
                <span class="text-xs text-gray-500">Statut</span>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                           onchange="this.form.requestSubmit()"
                           {{ $product->is_active ? 'checked' : '' }}>
                    <div class="relative w-9 h-5 bg-gray-200 rounded-full peer
                                peer-checked:bg-amani transition-colors duration-200
                                after:content-[''] after:absolute after:top-0.5 after:left-0.5
                                after:bg-white after:rounded-full after:h-4 after:w-4
                                after:transition-all after:duration-200
                                peer-checked:after:translate-x-4">
                    </div>
                </label>
            </form>
        @endauth
    </div>
</div>

<x-modals.confirm-delete id="deleteModal"
                       message="Êtes-vous sûr de vouloir supprimer ce produit ?" />