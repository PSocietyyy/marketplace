<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h1 class="text-3xl font-semibold mb-6">{{ $is_edit_mode ? "Edit" : "Tambah" }} Produk Baru</h1>

    <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-6">
        {{-- Nama Produk --}}
        <x-input 
            id="product_name"
            label="Nama Produk"
            placeholder="Masukkan nama produk"
            wire:model.defer="product_name"
            :error="$errors->first('product_name')"
            required
            icon="ri-product-hunt-line"
        />

        {{-- Deskripsi (textarea custom) --}}
        <div class="space-y-1">
            <label for="description" class="block text-sm font-medium text-gray-700">
                Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea 
                id="description" 
                wire:model.defer="description" 
                rows="4"
                placeholder="Masukkan deskripsi produk"
                class="block w-full rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-500 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 ease-in-out resize-none"
                required
            ></textarea>
            @error('description')
                <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                    <i class="ri-error-warning-line"></i> {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Harga --}}
        <x-input 
            id="price"
            type="number"
            label="Harga (Rp)"
            placeholder="Masukkan harga produk"
            wire:model.defer="price"
            :error="$errors->first('price')"
            required
            min="0"
            step="0.01"
            icon="ri-money-dollar-circle-line"
        />

        {{-- Stok --}}
        <x-input 
            id="stock"
            type="number"
            label="Stok"
            placeholder="Masukkan jumlah stok"
            wire:model.defer="stock"
            :error="$errors->first('stock')"
            required
            min="0"
            step="1"
            icon="ri-stack-line"
        />

        {{-- Kategori --}}
        <div class="space-y-1">
            <label for="category_id" class="block text-sm font-medium text-gray-700">
                Kategori <span class="text-red-500">*</span>
            </label>
            <select 
                id="category_id" 
                wire:model.defer="category_id"
                class="block w-full rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-500 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 ease-in-out"
                required
            >
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                    <i class="ri-error-warning-line"></i> {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Gambar --}}
        <div class="space-y-1">
            <label for="image" class="block text-sm font-medium text-gray-700">
                Gambar Produk <span class="text-red-500">*</span>
            </label>
            <input 
                type="file" 
                id="image" 
                wire:model="image" 
                accept="image/*"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-indigo-50 file:text-indigo-700
                hover:file:bg-indigo-100
                "
            >
            @error('image')
                <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                    <i class="ri-error-warning-line"></i> {{ $message }}
                </p>
            @enderror

            @if ($image)
                <div class="mt-4">
                    <span class="block text-sm font-medium text-gray-700 mb-1">Preview Gambar:</span>
                    <img src="{{ $image->temporaryUrl() }}" alt="Preview Gambar" class="max-h-48 rounded">
                </div>
            @endif
            @if ($currentImage)
                <div class="mt-4">
                    <span class="block text-sm font-medium text-gray-700 mb-1">Preview Gambar:</span>
                    <img src="{{ str_starts_with($currentImage, "https") ? $currentImage : asset('storage/'.$currentImage) }}" alt="Preview Gambar" class="max-h-48 rounded">
                </div>
            @endif
        </div>

        {{-- Tombol Simpan --}}
        <div class="pt-4">
            <x-button type="submit" variant="primary" class="w-full py-3 text-lg font-semibold">
                {{ $is_edit_mode ? "Edit" : "Simpan" }} Produk
            </x-button>
        </div>
    </form>
</div>