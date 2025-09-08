<div class="min-h-screen bg-gray-50 text-gray-900 px-3 sm:px-6 lg:px-8 py-12 max-w-7xl mx-auto">
    <div class="mb-5">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="md:col-span-2">
                    <div class="relative">
                        <i class="ri-search-line absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                        <input wire:model.live.debounce.200ms="search" type="text" placeholder="Cari produk..."
                            class="w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none transition-all duration-200 bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <div>
                    <select wire:model.live="categoryFilter"
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

            <div class="flex justify-between items-center mb-4">
                <div class="text-sm text-gray-600">
                    <span class="font-medium">{{ $products->total() }} produk</span>
                    @if ($search)
                        untuk "<span class="font-semibold text-gray-900">{{ $search }}</span>"
                    @endif
                    @if ($categoryFilter)
                        dalam "<span class="font-semibold text-gray-900">{{ $categories->find($categoryFilter)->name ?? '' }}</span>"
                    @endif
                </div>

                <div class="flex items-center space-x-3">
                    @if ($search || $categoryFilter)
                        <x-button 
                            variant="secondary" 
                            size="sm" 
                            wire:click="clearFilters"
                            class="flex items-center space-x-2"
                        >
                            <i class="ri-refresh-line"></i>
                            <span>Reset</span>
                        </x-button>
                    @endif

                    <x-button 
                        variant="primary" 
                        size="sm" 
                        wire:click="addProduct"
                        class="flex items-center space-x-2"
                    >
                        <i class="ri-add-line"></i>
                        <span>Tambah Produk</span>
                    </x-button>
                </div>
            </div>

            @if($products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('product_name')">
                                    Nama Produk
                                    @if($sortBy === 'product_name')
                                        @if($sortDirection === 'asc')
                                            <i class="ri-arrow-up-s-line inline"></i>
                                        @else
                                            <i class="ri-arrow-down-s-line inline"></i>
                                        @endif
                                    @endif
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">UMKN</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($products as $produk)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-16 h-16 bg-gray-100 flex items-center justify-center overflow-hidden rounded">
                                            @if (!empty($produk->image))
                                                <img src="{{ $produk->getUrlImage()}}" alt="{{ $produk->product_name }}" class="object-cover w-full h-full">
                                            @else
                                                <i class="ri-image-line text-3xl text-gray-400"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap max-w-xs truncate" title="{{ $produk->product_name }}">
                                        {{ $produk->product_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $produk->category->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $produk->umkn->umkn_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-semibold">
                                        Rp {{ number_format($produk->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        {{ $produk->stock }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center space-x-1">
                                        <x-button 
                                            variant="info" 
                                            size="xs" 
                                            wire:click="productDetail({{ $produk->id }})" 
                                            icon="ri-eye-line"
                                            iconPosition="left"
                                        >
                                            Detail
                                        </x-button>

                                        <x-button 
                                            variant="primary" 
                                            size="xs" 
                                            wire:click="editProduct({{ $produk->id }})" 
                                            icon="ri-edit-line"
                                            iconPosition="left"
                                        >
                                            Edit
                                        </x-button>

                                        <x-button 
                                            variant="danger" 
                                            size="xs" 
                                            wire:click="confirmDelete({{ $produk->id }})" 
                                            icon="ri-delete-bin-line"
                                            iconPosition="left"
                                        >
                                            Hapus
                                        </x-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
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
            @endif
        </div>
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