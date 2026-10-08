@props(['supplier', 'action'])

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="supplierForm" novalidate
      class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 max-w-4xl mx-auto">
    @csrf
    @if ($supplier->exists)
        @method('PUT')
    @endif

    {{-- Supplier company image (dropzone) --}}
    <div class="mb-8">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image du fournisseur</label>

        <label for="image" id="dropzone"
            class="group relative flex items-center justify-center w-full h-70 rounded-xl overflow-hidden cursor-pointer
                    border-2 border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800
                    hover:border-amani transition">

            {{-- Preview: shows the existing image in edit mode, hidden on create --}}
            <img src="{{ $supplier->image ? route('admin.storage.supplier', $supplier) : '' }}"
                alt="{{ $supplier->name }}"
                id="imagePreview"
                class="absolute inset-0 w-full h-full object-cover {{ $supplier->image ? '' : 'hidden' }}">

            {{-- Empty state: hidden when an image exists --}}
            <div id="imagePlaceholder"
                class="flex flex-col items-center gap-2 text-gray-400 dark:text-gray-500 {{ $supplier->image ? 'hidden' : '' }}">
                <i class="fa-solid fa-cloud-arrow-up text-4xl"></i>
                <p class="text-sm"><span class="text-amani font-medium">Cliquez pour choisir</span> ou glissez-déposez</p>
                <p class="text-xs">PNG, JPG ou JPEG</p>
            </div>

            {{-- Hover overlay: only useful when a preview is visible --}}
            <div id="imageOverlay"
                class="absolute inset-0 bg-black/50 text-white flex-col items-center justify-center gap-1 opacity-0 group-hover:opacity-100 transition
                        {{ $supplier->image ? 'flex' : 'hidden' }}">
                <i class="fa-solid fa-camera text-2xl"></i>
                <span class="text-sm">Changer l'image</span>
            </div>

            <input type="file" name="image" id="image" accept=".png,.jpg,.jpeg" class="hidden">
        </label>

        <p class="js-error text-xs text-red-600 mt-1 hidden" id="imageError"></p>
        @error('image')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom</label>
            <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}" required maxlength="80"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
            <p class="js-error text-xs text-red-600 mt-1 hidden"></p>
            @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Phone --}}
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Téléphone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}" required
                   placeholder="06XXXXXXXX" maxlength="10" inputmode="numeric"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
            <p class="js-error text-xs text-red-600 mt-1 hidden"></p>
            @error('phone')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Address --}}
        <div class="md:col-span-2">
            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse</label>
            <input type="text" name="address" id="address" value="{{ old('address', $supplier->address) }}"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
            @error('address')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Note --}}
        <div class="md:col-span-2">
            <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Note</label>
            <textarea name="note" id="note" rows="4"
                      class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                             focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition resize-none">{{ old('note', $supplier->note) }}</textarea>
            @error('note')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

    </div>

    <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
        <a href="{{ route('admin.suppliers.index') }}"
           class="cursor-pointer px-5 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
            Annuler
        </a>
        <button type="submit"
                class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2">
            <i class="fa-solid fa-check"></i> {{ $supplier->exists ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
    </div>

</form>

@push('scripts')
    @vite('resources/js/admin/supplier-form.js')
@endpush
