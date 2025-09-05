<div class="min-h-screen bg-white text-black px-4 py-8 max-w-5xl mx-auto">

    <h1 class="text-3xl font-bold mb-6 border-b border-gray-300 pb-2">Keranjang Belanja</h1>

    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (count($carts) === 0)
        <div class="text-center py-20 text-gray-500">
            <i class="ri-shopping-cart-line text-7xl mb-6"></i>
            <p class="text-xl font-semibold mb-2">Keranjang Anda kosong</p>
            <p>Tambahkan produk ke keranjang untuk memulai belanja.</p>
        </div>
    @else
        {{-- Checkbox Pilih Semua --}}
        <div class="mb-4 flex items-center space-x-2">
            <input type="checkbox" id="selectAll" wire:model="selectAll" wire:click="$toggle('selectAll')" />
            <label for="selectAll" class="font-medium select-none cursor-pointer">Pilih Semua</label>
        </div>

        <div class="space-y-6">
            @foreach ($carts as $item)
                <div class="flex border border-gray-300 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                    {{-- Checkbox --}}
                    <div class="flex items-center px-4">
                        <input type="checkbox" wire:model="selected" value="{{ $item['id'] }}" class="w-5 h-5 cursor-pointer" />
                    </div>

                    {{-- Gambar produk --}}
                    <div class="w-32 h-full bg-gray-100 flex items-center justify-center overflow-hidden">
                        @if ($item['image'])
                            <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}" class="object-cover w-full h-full">
                        @else
                            <i class="ri-image-line text-4xl text-gray-400"></i>
                        @endif
                    </div>

                    {{-- Detail produk --}}
                    <div class="flex flex-col flex-grow p-4">
                        <h2 class="text-lg font-semibold mb-1">{{ $item['product_name'] }}</h2>
                        <p class="text-gray-700 mb-2">Harga: <span class="font-bold">Rp {{ number_format($item['price'], 0, ',', '.') }}</span></p>
                        <p class="text-gray-600 mb-4">Subtotal: <span class="font-semibold">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span></p>

                        {{-- Kontrol qty --}}
                        <div class="flex items-center space-x-2">
                            <button wire:click="decrementQty({{ $item['id'] }})" 
                                    class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50"
                                    @if($item['qty'] <= 1) disabled @endif>-</button>
                            <span class="w-8 text-center font-medium">{{ $item['qty'] }}</span>
                            <button wire:click="incrementQty({{ $item['id'] }})" 
                                    class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50"
                                    @if($item['qty'] >= $item['stock']) disabled @endif>+</button>

                            <button wire:click="removeItem({{ $item['id'] }})" 
                                    class="ml-auto text-red-600 hover:text-red-800 font-semibold"
                                    title="Hapus produk">
                                <i class="ri-delete-bin-line text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Total dan Checkout --}}
            <div class="flex justify-between items-center border-t border-gray-300 pt-4">
                <span class="text-xl font-bold">Total:</span>
                <span class="text-xl font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <button wire:click="checkout" 
                    class="w-full mt-4 bg-black hover:bg-gray-900 text-white font-semibold py-3 rounded-lg transition-colors duration-200"
                    @if(count($selected) === 0) disabled @endif>
                Checkout
            </button>
        </div>
    @endif
</div>