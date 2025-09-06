<div class="min-h-screen min-w-full bg-gray-50 text-gray-900 px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-12">
            <h1 class="text-4xl lg:text-5xl font-light leading-tight mb-2">Keranjang Belanja</h1>
            <p class="text-gray-600">{{ count($carts) }} produk dalam keranjang</p>
        </div>

        @if (session()->has('message'))
            <div class="mb-8 bg-white border border-green-200 rounded-2xl p-4">
                <div class="flex items-center space-x-3">
                    <i class="ri-check-line text-xl text-green-600"></i>
                    <span class="text-green-800">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        @if (count($carts) === 0)
            <div class="text-center py-20">
                <div class="bg-white rounded-3xl p-12 shadow-sm border border-gray-100">
                    <i class="ri-shopping-cart-line text-6xl text-gray-300 mb-6"></i>
                    <h2 class="text-2xl font-light mb-3 text-gray-900">Keranjang Anda kosong</h2>
                    <p class="text-gray-600">Tambahkan produk ke keranjang untuk memulai belanja.</p>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <div class="flex items-center space-x-3">
                    <input type="checkbox" id="selectAll" wire:model="selectAll" wire:click.live="$toggle('selectAll')" 
                           class="w-5 h-5 rounded border-gray-300 text-gray-900 focus:ring-gray-900 focus:ring-2" />
                    <label for="selectAll" class="font-medium text-gray-900 cursor-pointer">Pilih Semua Produk</label>
                </div>
            </div>

            <div class="space-y-4 mb-8">
                @foreach ($carts as $item)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                        <div class="p-6">
                            <div class="flex items-start space-x-6">
                                
                                <div class="flex items-center pt-2">
                                    <input type="checkbox" wire:model.live="selected" value="{{ $item['id'] }}" 
                                           class="w-5 h-5 rounded border-gray-300 text-gray-900 focus:ring-gray-900 focus:ring-2" />
                                </div>

                                <div class="flex-shrink-0">
                                    <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden">
                                        @if ($item['image'])
                                            <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="ri-image-line text-2xl text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex-grow min-w-0">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-grow pr-4">
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">{{ $item['product_name'] }}</h3>
                                            <p class="text-gray-600">Rp {{ number_format($item['price'], 0, ',', '.') }} per unit</p>
                                        </div>
                                        <button wire:click="removeItem({{ $item['id'] }})" 
                                                class="text-gray-400 hover:text-red-500 transition-colors duration-200 p-2"
                                                title="Hapus produk">
                                            <i class="ri-delete-bin-line text-xl"></i>
                                        </button>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <span class="text-sm text-gray-600">Jumlah:</span>
                                            <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl overflow-hidden">
                                                <button wire:click="decrementQty({{ $item['id'] }})" 
                                                        class="px-3 py-2 hover:bg-gray-100 text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                                        @if($item['qty'] <= 1) disabled @endif>
                                                    <i class="ri-subtract-line"></i>
                                                </button>
                                                <div class="px-4 py-2 bg-white font-medium min-w-[3rem] text-center">
                                                    {{ $item['qty'] }}
                                                </div>
                                                <button wire:click="incrementQty({{ $item['id'] }})" 
                                                        class="px-3 py-2 hover:bg-gray-100 text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                                        @if($item['qty'] >= $item['stock']) disabled @endif>
                                                    <i class="ri-add-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-semibold text-gray-900">
                                                Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Stok: {{ $item['stock'] }} unit
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 space-y-6">
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Produk dipilih</span>
                            <span>{{ count($selected) }} item</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium text-gray-900">Total Pembayaran</span>
                                <span class="text-2xl font-semibold text-gray-900">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <button wire:click="checkout" 
                            class="w-full bg-gray-900 hover:bg-gray-800 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-medium py-4 rounded-xl transition-colors duration-200 text-lg"
                            @if(count($selected) === 0) disabled @endif>
                        <div class="flex items-center justify-center space-x-3">
                            <i class="ri-shopping-bag-line text-xl"></i>
                            <span>Checkout Sekarang</span>
                        </div>
                    </button>

                    @if(count($selected) === 0)
                        <p class="text-center text-sm text-gray-500">
                            Pilih produk untuk melanjutkan checkout
                        </p>
                    @endif
                </div>
            </div>

        @endif
    </div>
</div>