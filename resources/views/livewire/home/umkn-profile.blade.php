<div class="min-h-screen min-w-full bg-gray-50 text-gray-900 px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-6xl mx-auto">
        <!-- UMKN Header Section -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-8">
                <!-- UMKN Logo -->
                <div class="lg:col-span-1">
                    <div class="relative">
                        @if($umkn->logo)
                            <img src="{{ asset('storage/' . $umkn->logo) }}" 
                                 alt="{{ $umkn->umkn_name }}" 
                                 class="w-full h-64 object-cover rounded-2xl">
                        @else
                            <div class="w-full h-64 flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-150 rounded-2xl">
                                <i class="ri-store-line text-6xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- UMKN Info -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="space-y-4">
                        <h1 class="text-4xl lg:text-5xl font-medium leading-tight">
                            {{ $umkn->umkn_name }}
                        </h1>
                        
                        <div class="flex flex-wrap gap-3">
                            <span class="bg-blue-100 text-blue-700 text-sm px-4 py-2 rounded-full font-medium">
                                <i class="ri-store-line mr-1"></i>
                                UMKN
                            </span>
                            <span class="bg-gray-100 text-gray-700 text-sm px-4 py-2 rounded-full font-medium">
                                <i class="ri-box-line mr-1"></i>
                                {{ $products->total() }} Produk
                            </span>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    @if($umkn->description)
                    <div class="space-y-3">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="ri-information-line text-xl mr-2"></i>
                            Tentang UMKN
                        </h3>
                        <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $umkn->description }}</p>
                    </div>
                    @endif
                    
                    <!-- Contact Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900 flex items-center">
                                <i class="ri-map-pin-line text-xl mr-2 text-gray-600"></i>
                                Alamat
                            </h4>
                            <p class="text-gray-600 leading-relaxed">{{ $umkn->address }}</p>
                        </div>
                        
                        @if($umkn->number_phone)
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900 flex items-center">
                                <i class="ri-phone-line text-xl mr-2 text-gray-600"></i>
                                Kontak
                            </h4>
                            <a href="tel:{{ $umkn->number_phone }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium">{{ $umkn->number_phone }}</a>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Stats -->
                    <div class="bg-gray-50 rounded-2xl p-6">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div class="space-y-2">
                                <div class="text-2xl font-bold text-gray-900">{{ $products->total() }}</div>
                                <div class="text-sm text-gray-600">Total Produk</div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-2xl font-bold text-gray-900">{{ $totalSold ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Terjual</div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-2xl font-bold text-gray-900">{{ number_format($averageRating ?? 0, 1) }}</div>
                                <div class="text-sm text-gray-600 flex items-center justify-center">
                                    <i class="ri-star-fill text-yellow-400 text-xs mr-1"></i>
                                    Rating
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Products Section -->
        <div class="space-y-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <h2 class="text-3xl font-light text-gray-900">Produk {{ $umkn->umkn_name }}</h2>
                
                <!-- Search Bar -->
                <div class="flex-1 max-w-md lg:mx-8">
                    <div class="relative">
                        <input wire:model="search" 
                               type="text" 
                               placeholder="Cari produk..."
                               class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        <i class="ri-search-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>
            
            <!-- Filter and Sort Options -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select wire:model.live="selectedCategory" 
                                class="w-full bg-white border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Price Range Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                        <select wire:model.live="priceRange" 
                                class="w-full bg-white border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                            <option value="">Semua Harga</option>
                            <option value="0-50000">Di bawah 50rb</option>
                            <option value="50000-100000">50rb - 100rb</option>
                            <option value="100000-500000">100rb - 500rb</option>
                            <option value="500000-1000000">500rb - 1jt</option>
                            <option value="1000000-99999999">Di atas 1jt</option>
                        </select>
                    </div>
                    
                    <!-- Sort Options -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                        <select wire:model.live="sortBy" 
                                class="w-full bg-white border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="name_asc">Nama A-Z</option>
                            <option value="name_desc">Nama Z-A</option>
                            <option value="price_low">Harga Terendah</option>
                            <option value="price_high">Harga Tertinggi</option>
                        </select>
                    </div>
                    
                    <!-- Stock Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                        <label class="flex items-center">
                            <input wire:model.live="onlyInStock" 
                                   type="checkbox" 
                                   class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                            <span class="ml-2 text-sm text-gray-700">Tersedia saja</span>
                        </label>
                    </div>
                </div>
                
                <!-- Clear Filters Button -->
                <div class="flex justify-end">
                    <button wire:click="clearFilters" 
                            class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                        <i class="ri-close-line mr-1"></i>
                        Hapus Filter
                    </button>
                </div>
            </div>
            
            @if($products->count() > 0)
                <!-- Results Info -->
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <span>Menampilkan {{ $products->firstItem() }}-{{ $products->lastItem() }} dari {{ $products->total() }} produk</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 group">
                            <div class="relative">
                                @if($product->image)
                                    <a href="{{ route('home.product.detail', $product->id) }}">
                                        <img src="{{ $product->getUrlImage() }}" 
                                             alt="{{ $product->product_name }}" 
                                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                    </a>
                                @else
                                    <div class="w-full h-48 flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-150">
                                        <i class="ri-image-line text-4xl text-gray-400"></i>
                                    </div>
                                @endif
                                
                                <!-- Stock Badge -->
                                @if($product->stock > 0)
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-medium">
                                            Stok: {{ $product->stock }}
                                        </span>
                                    </div>
                                @else
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-medium">
                                            Habis
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-4 space-y-3">
                                <div class="space-y-2">
                                    <a href="{{ route('home.product.detail', $product->id) }}" 
                                       class="font-semibold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                        {{ $product->product_name }}
                                    </a>
                                    
                                    @if($product->category)
                                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                            {{ $product->category->name }}
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-sm text-gray-600 line-clamp-2">
                                    {{ $product->description }}
                                </p>
                                
                                <!-- Price and Rating -->
                                <div class="flex items-center justify-between pt-2">
                                    <div class="space-y-1">
                                        <div class="text-lg font-bold text-gray-900">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                        
                                        <!-- Rating -->
                                        @if($product->reviews_count > 0)
                                            <div class="flex items-center space-x-1 text-xs">
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="ri-star{{ $i <= round($product->reviews_avg_rating) ? '-fill text-yellow-400' : '-line text-gray-300' }} text-xs"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-gray-500">({{ $product->reviews_count }})</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Add to Cart Button -->
                                    <button onclick="event.preventDefault(); alert('Fitur keranjang belum diimplementasi')" 
                                            class="bg-gray-900 hover:bg-gray-800 text-white p-2 rounded-xl transition-colors opacity-0 group-hover:opacity-100">
                                        <i class="ri-shopping-cart-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl p-12 text-center">
                    <i class="ri-box-line text-6xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">
                        @if($search || $selectedCategory || $priceRange || $onlyInStock)
                            Tidak Ada Produk yang Sesuai
                        @else
                            Belum Ada Produk
                        @endif
                    </h3>
                    <p class="text-gray-600 mb-4">
                        @if($search || $selectedCategory || $priceRange || $onlyInStock)
                            Coba ubah filter pencarian Anda.
                        @else
                            UMKN ini belum menambahkan produk apapun.
                        @endif
                    </p>
                    
                    @if($search || $selectedCategory || $priceRange || $onlyInStock)
                        <button wire:click="clearFilters" 
                                class="bg-gray-900 text-white px-6 py-2 rounded-xl hover:bg-gray-800 transition-colors">
                            Hapus Semua Filter
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>