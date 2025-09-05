<div class="min-h-screen bg-white text-black max-w-5xl mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Gambar Produk --}}
        <div class="flex-shrink-0 w-full lg:w-1/2 rounded-lg overflow-hidden border border-gray-300">
            @if($product->image)
                <img src="{{ $product->image }}" alt="{{ $product->product_name }}" class="w-full h-auto object-cover">
            @else
                <div class="w-full h-64 flex items-center justify-center bg-gray-100 text-gray-400">
                    <i class="ri-image-line text-6xl"></i>
                </div>
            @endif
        </div>

        {{-- Detail Produk --}}
        <div class="flex flex-col flex-grow">
            <h1 class="text-3xl font-bold mb-4">{{ $product->product_name }}</h1>

            <div class="flex flex-wrap gap-3 mb-4 text-sm text-gray-600">
                @if($product->category)
                    <span class="bg-gray-200 rounded-full px-3 py-1">{{ $product->category->name }}</span>
                @endif
                @if($product->umkn)
                    <span class="bg-blue-600 text-white rounded-full px-3 py-1">{{ $product->umkn->umkn_name }}</span>
                @endif
            </div>

            <p class="text-gray-700 mb-6 whitespace-pre-line">{{ $product->description }}</p>

            <div class="text-2xl font-semibold mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

            <div class="mb-6 flex items-center space-x-4">
                <span class="text-gray-600">Stok: {{ $product->stock }}</span>

                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                    <button wire:click="decrementQty" 
                            class="px-3 py-1 bg-gray-200 hover:bg-gray-300 disabled:opacity-50" 
                            @if($qty <= 1) disabled @endif>-</button>
                    <input type="text" readonly class="w-12 text-center font-semibold" value="{{ $qty }}">
                    <button wire:click="incrementQty" 
                            class="px-3 py-1 bg-gray-200 hover:bg-gray-300 disabled:opacity-50" 
                            @if($qty >= $product->stock) disabled @endif>+</button>
                </div>
            </div>

            <button wire:click="addToCart" 
                    wire:loading.attr="disabled" 
                    wire:target="addToCart"
                    class="bg-black hover:bg-gray-900 text-white font-semibold py-3 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2 max-w-xs">
                <i class="ri-shopping-cart-line text-lg" wire:target="addToCart"></i>
                <span>Tambah ke Keranjang</span>
            </button>
        </div>
    </div>
</div>