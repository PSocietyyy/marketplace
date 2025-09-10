<div class="min-h-screen min-w-full bg-gray-50 text-gray-900 px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <div class="relative">
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 p-6">
                    @if ($product->image)
                        <img src="{{ $product->getUrlImage() }}" alt="{{ $product->product_name }}"
                            class="w-full h-96 object-cover rounded-2xl">
                    @else
                        <div
                            class="w-full h-96 flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-150 rounded-2xl">
                            <i class="ri-image-line text-6xl text-gray-400"></i>
                        </div>
                    @endif
                </div>

            </div>

            <div class="flex flex-col justify-center space-y-8">

                <div class="space-y-4">
                    <h1 class="text-4xl lg:text-5xl font-light leading-tight">
                        {{ $product->product_name }}
                    </h1>

                    <div class="flex flex-wrap gap-3">
                        @if ($product->category)
                            <span class="bg-gray-100 text-gray-700 text-sm px-4 py-2 rounded-full font-medium">
                                {{ $product->category->name }}
                            </span>
                        @endif
                        
                    </div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-lg font-medium text-gray-900">Deskripsi Produk</h3>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                </div>

                <div class="space-y-2">
                    <div class="text-3xl font-semibold text-gray-900">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center space-x-6">
                        <div class="text-gray-600">
                            <span class="text-sm font-medium">Stok Tersedia:</span>
                            <span class="text-lg font-semibold text-gray-900 ml-2">{{ $product->stock }} unit</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-16 grid grid-cols-1 gap-8">
            <div class="bg-white w-full rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center space-x-3 mb-4">
                    <i class="ri-information-line text-2xl text-gray-600"></i>
                    <h3 class="text-lg font-medium text-gray-900">Detail Produk</h3>
                </div>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Kategori</span>
                        <span class="font-medium text-gray-900">{{ $product->category->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>UMKN</span>
                        <span class="font-medium text-gray-900">{{ $product->umkn->umkn_name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Stok</span>
                        <span class="font-medium text-gray-900">{{ $product->stock }} unit</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
