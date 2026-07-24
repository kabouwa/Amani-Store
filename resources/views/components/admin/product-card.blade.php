@props(['product'])

<div class="group relative bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden">

    @guest
        {{-- Guests: whole card links out to the public product page --}}
        <a href="{{ route('products.show', $product->slug) }}" class="absolute inset-0 z-0" aria-label="{{ $product->title }}"></a>
    @endguest

    {{-- Admin actions --}}
    @auth
        <div class="absolute top-2 right-2 z-20 flex gap-1.5">
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

    {{-- Image carousel --}}
    <div class="relative aspect-square bg-gray-50 overflow-hidden js-carousel" data-autoplay="2000">

        @if($product->images->count())
            <div class="flex h-full transition-transform duration-500 ease-out js-carousel-track"
                 style="width: {{ $product->images->count() * 100 }}%;">
                @foreach ($product->images as $img)
                    <div class="h-full shrink-0" style="width: {{ 100 / $product->images->count() }}%;">
                        <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $product->title }}"
                             class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>

            @if($product->images->count() > 1)
                {{-- Prev / next --}}
                <button type="button"
                        class="js-carousel-prev cursor-pointer absolute left-2 top-1/2 -translate-y-1/2 z-20 w-7 h-7 rounded-full
                               bg-white/90 text-gray-700 hover:text-amani hover:bg-white shadow-sm flex items-center justify-center transition">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <button type="button"
                        class="js-carousel-next cursor-pointer absolute right-2 top-1/2 -translate-y-1/2 z-20 w-7 h-7 rounded-full
                               bg-white/90 text-gray-700 hover:text-amani hover:bg-white shadow-sm flex items-center justify-center transition">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>

                {{-- Dots --}}
                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 z-20 flex gap-1.5">
                    @foreach ($product->images as $index => $img)
                        <span class="js-carousel-dot w-1.5 h-1.5 rounded-full transition-all duration-200
                                      {{ $index === 0 ? 'bg-white w-4' : 'bg-white/50' }}"></span>
                    @endforeach
                </div>
            @endif
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-300">
                <i class="fa-solid fa-image text-4xl"></i>
            </div>
        @endif
    </div>

    {{-- Info --}}
    <div class="p-4 relative z-10">
        <p class="text-xs text-amani font-medium mb-1">{{ $product->category->title ?? 'Non Classé' }}</p>
        <h3 class="font-semibold text-gray-800 truncate mb-2">{{ $product->title }}</h3>

        {{-- Prices --}}
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-baseline gap-2">
                <span class="text-lg font-bold text-gray-900">{{ number_format($product->selling_price, 2) }} DH</span>
                @auth
                    <span class="text-xs text-gray-400">achat: {{ number_format($product->purchase_price, 2) }} DH</span>
                @endauth
            </div>
            <span class="text-xs {{ $product->stock > 0 ? 'text-gray-400' : 'text-red-500 font-medium' }}">
                {{ $product->stock > 0 ? $product->stock . ' en stock' : 'Rupture' }}
            </span>
        </div>

        {{-- Admin-only sales stats --}}
        @auth
            <div class="grid grid-cols-2 gap-2 mb-3 mt-3 pt-3 border-t border-gray-100">
                <div class="bg-gray-50 rounded-lg px-3 py-2">
                    <p class="text-[11px] text-gray-400">Ventes</p>
                    <p class="text-sm font-semibold text-gray-800">
                        <i class="fa-solid fa-bag-shopping text-amani text-xs mr-1"></i>{{ $product->sales_count ?? 0 }}
                    </p>
                </div>
                <div class="bg-gray-50 rounded-lg px-3 py-2">
                    <p class="text-[11px] text-gray-400">Total généré</p>
                    <p class="text-sm font-semibold text-gray-800">
                        {{ number_format($product->total_sales ?? 0, 2) }} DH
                    </p>
                </div>
            </div>
        @endauth

        {{-- Active toggle --}}
        @auth
            <form action="{{ route('admin.products.toggle', $product->slug) }}" method="POST"
                  class="flex items-center justify-between pt-3 border-t border-gray-100">
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