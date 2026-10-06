<x-admin.layouts.app title="Modifier un produit">
    <x-slot:heading>
        <i class="fa-solid fa-pen w-4 text-center"></i> Modifier un produit
    </x-slot:heading>

    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{url()->previous()}}"
               class="w-9 h-9 flex items-center justify-center rounded-full text-gray-500 dark:text-gray-400 hover:text-amani hover:bg-amani/10 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    Produit : {{ $product->title }}
                </h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Créée le {{ $product->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>
        </div>
    </div>

   @if($errors->any())
        <x-alert>Veuillez corriger les erreurs ci-dessous.</x-alert>
    @endif

    <x-admin.forms.product :product="$product" :categories="$categories" />


    <h1 class="text-2xl md:text-4xl font-bold text-gray-700 dark:text-gray-100 capitalize my-8">
        <i class="fa-solid fa-images"></i> Images de produit
    </h1>

    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif

    @if(session('error'))
        <x-alert>{{ session('error') }}</x-alert>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 mb-6">
        @forelse ($product->images as $index => $img)
            <div class="relative group md:aspect-square rounded-lg border overflow-hidden border-gray-200 dark:border-gray-700 cursor-pointer flex justify-center items-center bg-cover {{ $img->is_primary ? 'ring-2 ring-amani shadow-md shadow-amani/50' : '' }}"
                data-index="{{ $index }}" style="background: url({{ asset('storage/uploads/' . $img->image) }}) center no-repeat; background-size: cover;">

                <img src="{{ asset('storage/uploads/' . $img->image ) }}" class="js-viewable absolute inset-1 w-full h-full opacity-0">

                @if ($img->is_primary)
                    <div class="cursor-pointer md:absolute top-1 left-1 w-full md:w-6 h-6 rounded-full text-xs
                        bg-white/90 dark:bg-gray-900/90 text-red-600 dark:text-red-400 flex items-center justify-center opacity-100 transition shadow-sm">
                        <i class="{{ $img->is_primary ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
                    </div>
                @else
                    <form action={{ route('admin.product-image.primary', [$img, $product]) }} method="POST"
                        class="inline-block w-full py-1 px-2 save-position">
                        @csrf
                        @method('PATCH')
                        <button type="submit"  title="Mettre primaire"
                                class="cursor-pointer md:absolute top-1 left-1 w-full md:w-6 h-6 rounded-full
                                bg-white/90 dark:bg-gray-900/90 text-red-600 dark:text-red-400 flex items-center justify-center
                                opacity-100 md:opacity-0 group-hover:opacity-100 transition shadow-sm">
                                <i class="{{ $img->is_primary ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
                        </button>
                    </form>

                    <form action={{ route('admin.product-image.destroy', $img) }} method="POST"
                        class="inline-block w-full py-1 px-2 save-position">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="cursor-pointer md:absolute top-1 right-1 w-full md:w-6 h-6 rounded-full
                                    bg-white/90 dark:bg-gray-900/90 text-red-600 dark:text-red-400 flex items-center justify-center
                                    opacity-100 md:opacity-0 group-hover:opacity-100 transition shadow-sm">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    </form>
                @endif
            </div>

            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-14 h-14 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-image text-gray-300 dark:text-gray-600 text-xl"></i>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Aucune image pour ce produit</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Ajoutez des images via le formulaire ci-dessous.</p>
                </div>
        @endempty

    </div>

    <x-modals.image-preview />


    @push('scripts')
        @vite('resources/js/admin/product-images.js')
        @vite('resources/js/image-viewer.js')
    @endpush

</x-admin.layouts.app>
