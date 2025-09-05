{{-- resources/views/livewire/home/product-page.blade.php --}}
<div class="min-h-screen bg-white text-gray-900 px-4 sm:px-6 lg:px-8 py-8 max-w-7xl mx-auto">

    {{-- Header Section --}}
    <div class="mb-12">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 text-center sm:text-left">
            Semua <span class="text-gray-600">Produk</span>
        </h1>
        <div class="w-24 h-1 bg-black mx-auto sm:mx-0 mb-8"></div>
    </div>

    {{-- Filter Section --}}
    <div class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            {{-- Search Input --}}
            <div class="md:col-span-2">
                <div class="relative">
                    <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari produk..."
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200">
                </div>
            </div>

            {{-- Category Filter --}}
            <div>
                <select wire:model.live="selectedCategory"
                    class="w-full py-3 px-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Additional Filters --}}
        <div class="flex flex-wrap gap-3 items-center">
            {{-- Price Range Filter --}}
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Harga:</label>
                <select wire:model.live="priceRange"
                    class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none">
                    <option value="">Semua Harga</option>
                    <option value="0-50000">Di bawah Rp 50.000</option>
                    <option value="50000-100000">Rp 50.000 - Rp 100.000</option>
                    <option value="100000-500000">Rp 100.000 - Rp 500.000</option>
                    <option value="500000-999999999">Di atas Rp 500.000</option>
                </select>
            </div>

            {{-- Sort Filter --}}
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Urutkan:</label>
                <select wire:model.live="sortBy"
                    class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="price_low">Harga Terendah</option>
                    <option value="price_high">Harga Tertinggi</option>
                    <option value="name_asc">Nama A-Z</option>
                    <option value="name_desc">Nama Z-A</option>
                </select>
            </div>

            {{-- Stock Filter --}}
            <div class="flex items-center space-x-2">
                <input wire:model.live="onlyInStock" type="checkbox" id="inStock"
                    class="w-4 h-4 text-gray-900 bg-gray-100 border-gray-300 rounded focus:ring-gray-900 focus:ring-2">
                <label for="inStock" class="text-sm font-medium text-gray-700">Hanya yang tersedia</label>
            </div>

            {{-- Clear Filters --}}
            @if ($search || $selectedCategory || $priceRange || $sortBy !== 'newest' || $onlyInStock)
                <button wire:click="clearFilters"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg transition-colors duration-200">
                    <i class="ri-refresh-line mr-1"></i>
                    Reset Filter
                </button>
            @endif
        </div>

        {{-- Results Count --}}
        <div class="mt-4 text-sm text-gray-600">
            Menampilkan {{ $products->count() }} produk
            @if ($search)
                untuk "<span class="font-semibold">{{ $search }}</span>"
            @endif
            @if ($selectedCategory)
                dalam kategori "<span
                    class="font-semibold">{{ $categories->find($selectedCategory)->name ?? '' }}</span>"
            @endif
        </div>
    </div>

    {{-- Products Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
        @forelse ($products as $produk)
            <div
            wire:click='productDetail({{ $produk['id'] ?? 0 }})'
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
            <div class="col-span-full text-center py-12 text-gray-500">
                <i class="ri-search-line text-6xl mb-4"></i>
                <h3 class="font-semibold mb-2 text-lg">Produk tidak ditemukan</h3>
                <p class="mb-4">Coba ubah kata kunci pencarian atau filter yang Anda gunakan</p>
                @if ($search || $selectedCategory || $priceRange || $onlyInStock)
                    <button wire:click="clearFilters"
                        class="px-6 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-lg transition-colors duration-200">
                        Reset Semua Filter
                    </button>
                @endif
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

    {{-- Filter Loading Indicator --}}
    <div wire:loading wire:target="search,selectedCategory,priceRange,sortBy,onlyInStock"
        class="fixed bottom-4 right-4 bg-white shadow-lg rounded-lg p-3 flex items-center space-x-2 border">
        <i class="ri-loader-line animate-spin text-gray-600"></i>
        <span class="text-gray-700 text-sm">Memuat produk...</span>
    </div>
</div>
