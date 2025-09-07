<div class="min-h-screen bg-gray-50 text-gray-900 px-4 sm:px-6 lg:px-8 py-12 max-w-7xl mx-auto">

    <div class="mb-10">
        <div class="text-center mb-8">
            <h1 class="text-4xl sm:text-5xl font-light mb-3">
                Manajemen <span class="text-gray-500 font-extralight">Produk</span>
            </h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Kelola produk UMKN Anda dengan mudah</p>
        </div>
    </div>

    <div class="mb-10">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="md:col-span-2">
                    <div class="relative">
                        <i class="ri-search-line absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                        <input wire:model.debounce.300ms="search" type="text" placeholder="Cari produk..."
                            class="w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <div>
                    <select wire:model="categoryFilter"
                        class="w-full py-3.5 px-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-gray-50 focus:bg-white">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <div class="relative">
                        <button type="button" wire:click="sortBy('product_name')" 
                            class="w-full py-3.5 px-4 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none flex items-center justify-between">
                            <span>Urutkan: 
                                @if($sortBy === 'product_name')
                                    {{ $sortDirection === 'asc' ? 'A-Z' : 'Z-A' }}
                                @elseif($sortBy === 'created_at')
                                    {{ $sortDirection === 'asc' ? 'Terlama' : 'Terbaru' }}
                                @else
                                    Default
                                @endif
                            </span>
                            <i class="ri-arrow-down-s-line ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    <span class="font-medium">{{ $products->total() }} produk</span>
                    @if ($search)
                        untuk "<span class="font-semibold text-gray-900">{{ $search }}</span>"
                    @endif
                    @if ($categoryFilter)
                        dalam "<span class="font-semibold text-gray-900">{{ $categories->find($categoryFilter)->name ?? '' }}</span>"
                    @endif
                </div>

                @if ($search || $categoryFilter)
                    <x-button 
                        variant="secondary" 
                        size="sm" 
                        wire:click="$set('search', '')" 
                        wire:click="$set('categoryFilter', '')"
                        class="flex items-center space-x-2"
                    >
                        <i class="ri-refresh-line"></i>
                        <span>Reset</span>
                    </x-button>
                @endif
            </div>
        </div>
    </div>

    <div class="space-y-6">
        @forelse ($products as $produk)
            <div class="flex bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                {{-- Gambar --}}
                <div class="w-48 h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                    @if (!empty($produk->image))
                        <img src="{{ $produk->image }}" alt="{{ $produk->product_name }}" class="object-cover w-full h-full">
                    @else
                        <i class="ri-image-line text-6xl text-gray-400"></i>
                    @endif
                </div>

                {{-- Detail Produk --}}
                <div class="flex flex-col flex-grow p-6">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2 truncate">{{ $produk->product_name }}</h3>

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

                    <p class="text-gray-700 text-sm leading-relaxed mb-4 line-clamp-3 flex-grow">
                        {{ \Illuminate\Support\Str::limit($produk->description, 120) }}
                    </p>

                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xl font-semibold text-gray-900">
                            Rp {{ number_format($produk->price, 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-gray-500 bg-gray-50 px-3 py-1 rounded-full">
                            Stok: {{ $produk->stock }}
                        </span>
                    </div>

                    {{-- Tombol aksi --}}
                    <div class="flex space-x-3">
                        <x-button 
                            variant="info" 
                            size="sm" 
                            wire:click="productDetail({{ $produk->id }})" 
                            icon="ri-eye-line"
                            iconPosition="left"
                        >
                            Detail
                        </x-button>

                        <x-button 
                            variant="primary" 
                            size="sm" 
                            wire:click="editProduct({{ $produk->id }})" 
                            icon="ri-edit-line"
                            iconPosition="left"
                        >
                            Edit
                        </x-button>

                        <x-button 
                            variant="danger" 
                            size="sm" 
                            wire:click="confirmDelete({{ $produk->id }})" 
                            icon="ri-delete-bin-line"
                            iconPosition="left"
                        >
                            Hapus
                        </x-button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="ri-search-line text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-xl font-medium text-gray-900 mb-3">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Coba ubah kata kunci pencarian atau filter yang Anda gunakan untuk menemukan produk yang sesuai</p>
                    @if ($search || $categoryFilter)
                        <x-button 
                            variant="primary" 
                            wire:click="clearFilters"
                            class="px-6 py-3 rounded-xl font-medium"
                        >
                            Reset Semua Filter
                        </x-button>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>

    {{-- Modal Hapus --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6">
                <h2 class="text-xl font-semibold mb-4">Konfirmasi Hapus Produk</h2>
                <p class="mb-6">Apakah Anda yakin ingin menghapus produk <strong>{{ $productToDelete->product_name ?? '' }}</strong>?</p>
                <div class="flex justify-end space-x-4">
                    <x-button variant="secondary" size="sm" wire:click="cancelDelete">Batal</x-button>
                    <x-button variant="danger" size="sm" wire:click="deleteProduct">Hapus</x-button>
                </div>
            </div>
        </div>
    @endif

</div>