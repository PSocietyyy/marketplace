{{-- resources/views/livewire/umkn-rekomendasi.blade.php --}}
<div class="min-h-screen bg-white text-gray-900 px-4 sm:px-6 lg:px-8 py-8 max-w-7xl mx-auto">

    {{-- Header Section --}}
    <div class="mb-12">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 text-center sm:text-left">
            UMKN <span class="text-gray-600">Rekomendasi</span>
        </h1>
        <div class="w-24 h-1 bg-black mx-auto sm:mx-0 mb-8"></div>
    </div>

    {{-- UMKN Rekomendasi Section --}}
    <div class="mb-16">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">UMKN Terbaik</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
            @foreach ($umknRekomendasi as $umkn)
                <div
                    class="border border-gray-300 rounded-lg p-4 flex flex-col items-center text-center hover:shadow-lg transition-shadow duration-200">
                    <img src="{{ $umkn['logo'] }}" alt="{{ $umkn['umkn_name'] }}"
                        class="w-20 h-20 object-cover rounded-full mb-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $umkn['umkn_name'] }}</h2>
                    <p class="text-gray-700 text-sm">{{ $umkn['description'] }}</p>
                </div>
            @endforeach
        </div>

    </div>

    {{-- Produk Terlaris Section --}}
    <div class="mb-8">
        <div class="mb-8">
            <h2 class="text-3xl sm:text-4xl font-bold mb-4 text-center sm:text-left">
                Produk <span class="text-gray-600">Terlaris</span>
            </h2>
            <div class="w-24 h-1 bg-black mx-auto sm:mx-0"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse ($produkTerlaris as $produk)
                <div
                    class="bg-white border border-gray-300 rounded-xl overflow-hidden hover-scale hover:border-gray-700 transition-all duration-200 group">
                    <div class="relative overflow-hidden">
                        @if (!empty($produk['image']))
                            <img src="{{ $produk['image'] }}" alt="{{ $produk['product_name'] }}"
                                class="w-full h-36 sm:h-44 object-cover transition-transform duration-200 group-hover:scale-105 rounded-t-xl">
                        @else
                            <div
                                class="w-full h-36 sm:h-44 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center group-hover:from-gray-700 group-hover:to-gray-500 transition-all duration-200 rounded-t-xl">
                                <i
                                    class="ri-image-line text-3xl text-gray-400 group-hover:text-white transition-colors duration-200"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 flex flex-col text-sm sm:text-base">
                        <h3 class="font-semibold mb-1 group-hover:text-gray-800 truncate">{{ $produk['product_name'] }}
                        </h3>

                        {{-- Kategori dan UMKN --}}
                        <div class="flex flex-wrap gap-1 mb-1 text-xs text-gray-500">
                            @if (!empty($produk->category->name))
                                <span
                                    class="bg-gray-200 font-medium rounded-full px-2 py-0.5 truncate">{{ $produk->category->name }}</span>
                            @endif
                            @if (!empty($produk->umkn->umkn_name))
                                <span
                                    class="bg-blue-500 text-white font-medium rounded-full px-2 py-0.5 truncate">{{ $produk->umkn->umkn_name }}</span>
                            @endif
                        </div>

                        <p class="text-gray-600 leading-snug mb-3 line-clamp-3">
                            {{ \Illuminate\Support\Str::limit($produk['description'], 60) }}
                        </p>

                        <div class="flex justify-between items-center mb-3 text-sm">
                            <span class="font-bold">Rp {{ number_format($produk['price'], 0, ',', '.') }}</span>
                            <span class="text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">Stok:
                                {{ $produk['stock'] }}</span>
                        </div>

                        <button wire:click="addToCart({{ $produk['id'] ?? 0 }})" wire:loading.attr="disabled"
                            wire:target="addToCart({{ $produk['id'] ?? 0 }})"
                            class="w-full bg-gray-900 hover:bg-gray-800 disabled:bg-gray-500 disabled:cursor-not-allowed text-white font-medium py-2 rounded-lg transition duration-200 flex items-center justify-center space-x-2 text-sm">
                            <i class="ri-shopping-cart-line" wire:loading.class="animate-spin ri-loader-line"
                                wire:target="addToCart({{ $produk['id'] ?? 0 }})"></i>
                            <span wire:loading.remove wire:target="addToCart({{ $produk['id'] ?? 0 }})">Tambah ke
                                Keranjang</span>
                            <span wire:loading wire:target="addToCart({{ $produk['id'] ?? 0 }})">Menambahkan...</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-gray-500 text-sm">
                    <i class="ri-shopping-bag-line text-5xl mb-3"></i>
                    <p class="font-semibold mb-1">Belum ada produk</p>
                    <p>Produk terlaris akan muncul di sini</p>
                </div>
            @endforelse
        </div>

        {{-- Loading Overlay --}}
        <div wire:loading.flex wire:target="addToCart"
            class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
                <i class="ri-loader-line animate-spin text-2xl text-gray-600"></i>
                <span class="text-gray-700">Menambahkan ke keranjang...</span>
            </div>
        </div>
    </div>
