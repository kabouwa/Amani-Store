@props([
    'product' => null,
    'categories' => [],
])
<form action={{ $product ? route('admin.products.update', $product->slug) : route('admin.products.store') }} method="POST" novalidate enctype="multipart/form-data"
      class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
    @csrf
    @unless ( is_null($product) )
        @method('PUT')
    @endunless

    {{-- Image upload section --}}
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Ajouter des images</label>
            <span id="imagesCount" class="text-xs text-gray-400 dark:text-gray-500">{{ $product ? count($product->images) : 0 }} / 10</span>
        </div>

        {{-- Drop zone --}}
        <div id="dropZone"
            class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center
                    hover:border-amani dark:hover:border-amani-light hover:bg-amani/5 dark:hover:bg-amani/10 transition-all duration-200 cursor-pointer">

            <input type="file" name="images[]" id="imagesInput" accept=".png,.jpg,.jpeg" multiple
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

            <div class="flex flex-col items-center gap-3 pointer-events-none">
                <div class="w-14 h-14 rounded-full bg-amani/10 dark:bg-amani/20 flex items-center justify-center">
                    <i class="fa-solid fa-cloud-arrow-up text-amani dark:text-amani-light text-2xl"></i>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-200">
                        Glissez vos images ici ou <span class="text-amani dark:text-amani-light">parcourir</span>
                    </p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                        PNG, JPG, JPEG — jusqu'à {{ $product ? 10 - count($product->images) : 10 }} images
                    </p>
                </div>
            </div>
        </div>

        @error('images')
            <p class="text-xs text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
        @enderror

        @error('images.*')
            <p class="text-xs text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
        @enderror

        {{-- Preview grid --}}
        <div id="imagesPreview" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 mt-5"
             data-img-count="{{ $product ? count($product->images) : 0 }}"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Titre</label>
            <input type="text" name="title" id="title"
                   value="{{ old('title', $product ? $product->title : '') }}" required
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 px-4 py-2.5
                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
            @error('title')
                <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Category --}}
        <div class="relative">
            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Catégorie</label>

            <select name="category_id" id="category_id" required
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2.5 cursor-pointer
                           focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">

                <option value="" {{ old('category_id', $product?->category?->id ) === null ? 'selected' : '' }}>
                    Non Classé
                </option>

                @foreach ($categories as $cat)
                    <option value={{ $cat->id }} {{ old('category_id', $product?->category?->id ) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->title }}
                    </option>
                @endforeach
            </select>

            <div class="absolute top-8 right-1 bg-white dark:bg-gray-800 px-2 pointer-events-none text-gray-400 dark:text-gray-500 text-lg">
                <i class="fa-solid fa-angle-down"></i>
            </div>

            @error('category_id')
                <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Purchase price --}}
        <div>
            <label for="purchase_price" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Prix d'achat</label>

            <div class="relative">
                <input type="number" step="0.01" min="0" name="purchase_price" id="purchase_price"
                       value={{ old('purchase_price', $product ? $product->purchase_price : 0) }} required
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2.5 pr-12
                              focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">

                <span class="absolute inset-y-0 right-3 flex items-center text-gray-400 dark:text-gray-500 text-sm">DH</span>
            </div>

            @error('purchase_price')
                <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Selling price --}}
        <div>
            <label for="selling_price" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Prix de vente</label>

            <div class="relative">
                <input type="number" step="0.01" min="0" name="selling_price" id="selling_price"
                       value={{ old('selling_price', $product ? $product->selling_price : 0) }} required
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2.5 pr-12
                              focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">

                <span class="absolute inset-y-0 right-3 flex items-center text-gray-400 dark:text-gray-500 text-sm">DH</span>
            </div>

            @error('selling_price')
                <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Stock --}}
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Stock</label>

            <input type="number" min="0" name="stock" id="stock"
                   value={{ old('stock', $product ? $product->stock : 0) }} required
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2.5
                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">

            @error('stock')
                <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Active switch --}}
        <div class="flex flex-col justify-center">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Statut</label>

            <label class="inline-flex items-center cursor-pointer gap-3 w-fit">
                <input type="hidden" name="is_active" value="0">

                <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                       {{ old('is_active', $product?->is_active ?? true) ? 'checked' : '' }}>

                <div class="relative w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full peer
                            peer-checked:bg-amani transition-colors duration-200
                            after:content-[''] after:absolute after:top-0.5 after:left-0.5
                            after:bg-white after:rounded-full after:h-5 after:w-5
                            after:transition-all after:duration-200
                            peer-checked:after:translate-x-5">
                </div>

                <span class="text-sm text-gray-600 dark:text-gray-300">Produit actif</span>
            </label>
        </div>

        {{-- Description --}}
        <div class="md:col-span-2">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Description</label>

            <textarea name="description" id="description" rows="4"
                      class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 px-4 py-2.5
                             focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition resize-none">{{ old('description', $product ? $product->description : '') }}</textarea>

            @error('description')
                <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Submit --}}
    <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">

        <a href="{{ route('admin.products.index') }}"
           class="cursor-pointer px-5 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
            Annuler
        </a>

        @unless (is_null($product))
            <button type="button"
                    class="js-delete-btn cursor-pointer text-amani dark:text-amani-light hover:bg-gray-100 dark:hover:bg-gray-800 px-6 py-2.5 rounded-lg transition flex items-center gap-2"
                    data-action={{ route('admin.products.destroy', $product->slug) }}>
                <i class="fa-solid fa-trash"></i> Supprimer
            </button>
        @endunless

        <button type="submit"
                class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2">
            <i class="fa-solid fa-check"></i> Enregistrer
        </button>
    </div>
</form>

@unless (is_null($product))
    <x-modals.confirm-delete id="deleteModal"
            message="Êtes-vous sûr de vouloir supprimer ce client avec sa commande ?" />
@endunless