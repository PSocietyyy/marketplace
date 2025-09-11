<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h1 class="text-3xl font-semibold mb-6">{{ $is_edit_mode ? 'Edit' : 'Tambah' }} Kategori </h1>

    <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-6">
        {{-- Nama Produk --}}
        <x-input id="name" label="Nama Kategori" placeholder="Masukkan nama kategori" wire:model.defer="name"
            :error="$errors->first('name')" required icon="ri-product-hunt-line" />

        {{-- Tombol Simpan --}}
        <div class="pt-4">
            <x-button type="submit" variant="primary" class="w-full py-3 text-lg font-semibold">
                {{ $is_edit_mode ? 'Edit' : 'Simpan' }} Kategori
            </x-button>
        </div>
    </form>
</div>
