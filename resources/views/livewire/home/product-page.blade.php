<div class="min-h-screen min-w-full bg-gray-50 text-gray-900 px-4 sm:px-6 lg:px-8 py-12 max-w-7xl mx-auto">

    <div class="mb-10">
        <div class="text-center mb-8">
            <h1 class="text-4xl sm:text-5xl font-light mb-3">
                Semua <span class="text-gray-500 font-extralight">Produk</span>
            </h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Jelajahi koleksi lengkap produk UMKN terbaik</p>
        </div>
    </div>

    <div class="mb-10">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="md:col-span-2">
                    <div class="relative">
                        <i class="ri-search-line absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari produk..."
                            class="w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <div>
                    <select wire:model.live="selectedCategory"
                        class="w-full py-3.5 px-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-gray-50 focus:bg-white">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div class="flex flex-wrap gap-4 items-center">
                    <div class="flex items-center space-x-3">
                        <label class="text-sm font-medium text-gray-700">Harga:</label>
                        <select wire:model.live="priceRange"
                            class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none bg-gray-50 focus:bg-white min-w-[160px]">
                            <option value="">Semua Harga</option>
                            <option value="0-50000">< Rp 50.000</option>
                            <option value="50000-100000">Rp 50.000 - 100.000</option>
                            <option value="100000-500000">Rp 100.000 - 500.000</option>
                            <option value="500000-999999999">> Rp 500.000</option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-3">
                        <label class="text-sm font-medium text-gray-700">Urutkan:</label>
                        <select wire:model.live="sortBy"
                            class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none bg-gray-50 focus:bg-white min-w-[140px]">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="price_low">Harga Terendah</option>
                            <option value="price_high">Harga Tertinggi</option>
                            <option value="name_asc">Nama A-Z</option>
                            <option value="name_desc">Nama Z-A</option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-3">
                        <input wire:model.live="onlyInStock" type="checkbox" id="inStock"
                            class="w-4 h-4 text-gray-900 bg-gray-100 border-gray-300 rounded focus:ring-gray-900 focus:ring-2">
                        <label for="inStock" class="text-sm font-medium text-gray-700">Hanya yang tersedia</label>
                    </div>
                </div>

                @if ($search || $selectedCategory || $priceRange || $sortBy !== 'newest' || $onlyInStock)
                    <button wire:click="clearFilters"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg transition-colors duration-200 flex items-center space-x-2">
                        <i class="ri-refresh-line"></i>
                        <span>Reset</span>
                    </button>
                @endif
            </div>

            <div class="mt-6 pt-4 border-t border-gray-100">
                <div class="text-sm text-gray-600">
                    <span class="font-medium">{{ $products->count() }} produk</span>
                    @if ($search)
                        untuk "<span class="font-semibold text-gray-900">{{ $search }}</span>"
                    @endif
                    @if ($selectedCategory)
                        dalam "<span class="font-semibold text-gray-900">{{ $categories->find($selectedCategory)->name ?? '' }}</span>"
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($products as $produk)
            <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-lg hover:border-gray-200 transition-all duration-300 group">
                
                <div class="relative overflow-hidden cursor-pointer" wire:click='productDetail({{ $produk['id'] ?? 0 }})'>
                    @if (!empty($produk['image']))
                        <img src="{{ $produk['image'] }}" alt="{{ $produk['product_name'] }}"
                            class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-150 flex items-center justify-center group-hover:from-gray-200 group-hover:to-gray-250 transition-all duration-300">
                            <i class="ri-image-line text-4xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
                
                <div class="p-5">
                    <div class="mb-4">
                        <h3 class="font-medium text-lg mb-2 text-gray-900 truncate cursor-pointer hover:text-gray-700 transition-colors" 
                            wire:click='productDetail({{ $produk['id'] ?? 0 }})'>
                            {{ $produk['product_name'] }}
                        </h3>
                        
                        <div class="flex flex-wrap gap-2 mb-3">
                            @if (!empty($produk->category->name))
                                <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full font-medium">
                                    {{ $produk->category->name }}
                                </span>
                            @endif
                            @if (!empty($produk->umkn->umkn_name))
                                <span class="bg-blue-50 text-blue-700 text-xs px-3 py-1 rounded-full font-medium">
                                    {{ $produk->umkn->umkn_name }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-2">
                        {{ \Illuminate\Support\Str::limit($produk['description'], 80) }}
                    </p>

                    <div class="flex justify-between items-center mb-5">
                        <span class="text-xl font-semibold text-gray-900">
                            Rp {{ number_format($produk['price'], 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-gray-500 bg-gray-50 px-3 py-1 rounded-full">
                            Stok: {{ $produk['stock'] }}
                        </span>
                    </div>

                    <div class="flex gap-3">
                        <button wire:click="addToCart({{ $produk['id'] ?? 0 }})" 
                            wire:loading.attr="disabled"
                            wire:target="addToCart({{ $produk['id'] ?? 0 }})"
                            class="flex-1 bg-gray-900 hover:bg-gray-800 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-medium py-3 rounded-xl transition duration-200 text-sm">
                            <span wire:loading.remove wire:target="addToCart({{ $produk['id'] ?? 0 }})">Beli Sekarang</span>
                            <span wire:loading wire:target="addToCart({{ $produk['id'] ?? 0 }})">Loading...</span>
                        </button>
                        
                        <button wire:click="addToCart({{ $produk['id'] ?? 0 }})" 
                            wire:loading.attr="disabled"
                            wire:target="addToCart({{ $produk['id'] ?? 0 }})"
                            class="w-12 h-12 border border-gray-300 hover:bg-gray-900 hover:text-white hover:border-gray-900 text-gray-700 disabled:bg-gray-100 disabled:cursor-not-allowed rounded-xl transition duration-200 flex items-center justify-center">
                            <i class="ri-shopping-cart-line text-lg" 
                               wire:loading.class="animate-spin ri-loader-line"
                               wire:target="addToCart({{ $produk['id'] ?? 0 }})"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="ri-search-line text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-xl font-medium text-gray-900 mb-3">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Coba ubah kata kunci pencarian atau filter yang Anda gunakan untuk menemukan produk yang sesuai</p>
                    @if ($search || $selectedCategory || $priceRange || $onlyInStock)
                        <button wire:click="clearFilters"
                            class="px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white rounded-xl transition-colors duration-200 font-medium">
                            Reset Semua Filter
                        </button>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <div wire:loading.flex wire:target="addToCart"
        class="fixed inset-0 bg-black bg-opacity-30 items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 flex items-center space-x-4 shadow-2xl">
            <i class="ri-loader-line animate-spin text-2xl text-gray-600"></i>
            <span class="text-gray-700 font-medium">Menambahkan ke keranjang...</span>
        </div>
    </div>

    <div wire:loading wire:target="search,selectedCategory,priceRange,sortBy,onlyInStock"
        class="fixed bottom-6 right-6 bg-white shadow-lg rounded-2xl p-4 flex items-center space-x-3 border border-gray-100">
        <i class="ri-loader-line animate-spin text-gray-600"></i>
        <span class="text-gray-700 text-sm font-medium">Memuat produk...</span>
    </div>
</div>