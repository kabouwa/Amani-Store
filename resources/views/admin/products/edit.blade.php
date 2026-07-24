<x-admin.layouts.app title="Modifier un produit">
    <x-slot:heading>
        <i class="fa-solid fa-bag-shopping w-4 text-center"></i> Modifier un produit
    </x-slot:heading>
    
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <x-alert>{{ $error }}</x-alert>
        @endforeach
    @endif

    <x-admin.forms.product :product="$product" :categories="$categories" />


    <h1 class="text-4xl font-bold text-gray-700 capitalize my-8"><i class="fa-solid fa-images"></i> Images de produit</h1>

    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif
    @if(session('error'))
        <x-alert>{{ session('error') }}</x-alert>
    @endif


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
        @foreach ($product->images as $index => $img)
            <div class="relative group md:aspect-square rounded-lg border overflow-hidden border-gray-200 cursor-pointer {{ $img->is_primary ? 'ring-2 ring-amani shadow-md shadow-amani/50' : '' }}" 
                data-index="{{ $index }}">
                <img src="{{ asset('storage/' . $img->image ) }}" class="js-viewable w-full object-cover">

                @if ($img->is_primary)
                    <div class="cursor-pointer block md:absolute top-1 left-1 w-full md:w-6 h-6 rounded-full
                        bg-white/90 text-red-600 flex items-center justify-center
                        opacity-100 transition shadow-sm">
                        <i class="{{ $img->is_primary ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
                    </div>
                @else
                    <form action={{ route('product-image.primary', [$img, $product]) }} method="POST"
                        class="inline-block w-full py-1 px-2 save-position">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="cursor-pointer block md:absolute top-1 left-1 w-full md:w-6 h-6 rounded-full
                                bg-white/90 text-red-600 flex items-center justify-center
                                opacity-100 md:opacity-0 group-hover:opacity-100 transition shadow-sm">
                                <i class="{{ $img->is_primary ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
                        </button>  
                    </form>

                    <form action={{ route('product-image.destroy', $img) }} method="POST"
                        class="inline-block w-full py-1 px-2 save-position">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="cursor-pointer block md:absolute top-1 right-1 w-full md:w-6 h-6 rounded-full
                                    bg-white/90 text-red-600 flex items-center justify-center
                                    opacity-100 md:opacity-0 group-hover:opacity-100 transition shadow-sm">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>  
                    </form>    
                @endif

            </div>  
        @endforeach
    </div>

    <x-modals.image-preview />


    @push('scripts')
        @vite('resources/js/admin/product-images.js')
        @vite('resources/js/image-viewer.js')
    @endpush

</x-admin.layouts.app>
