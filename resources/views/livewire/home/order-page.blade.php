<div class="min-h-screen min-w-full bg-gray-50 text-gray-900 px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-4xl mx-auto">
        
        <div class="mb-12">
            <h1 class="text-4xl lg:text-5xl font-light leading-tight mb-2">Daftar Order Saya</h1>
            <p class="text-gray-600">Kelola dan pantau pesanan Anda</p>
        </div>

        @if (session()->has('message'))
            <div class="mb-8 bg-white border border-green-200 rounded-2xl p-4">
                <div class="flex items-center space-x-3">
                    <i class="ri-check-line text-xl text-green-600"></i>
                    <span class="text-green-800">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
            <div class="flex items-center space-x-4">
                <span class="text-gray-700 font-medium">Filter Status:</span>
                <select wire:model.live="statusFilter" 
                        class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                    <option value="all">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="shipped">Shipped</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        @if ($orders->isEmpty())
            <div class="text-center py-20">
                <div class="bg-white rounded-3xl p-12 shadow-sm border border-gray-100">
                    <i class="ri-file-list-line text-6xl text-gray-300 mb-6"></i>
                    <h2 class="text-2xl font-light mb-3 text-gray-900">Belum ada order</h2>
                    <p class="text-gray-600">Mulai belanja dan buat order pertama Anda.</p>
                </div>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
                        
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-grow">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h3>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'paid') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                                            @elseif($order->status === 'completed') bg-green-100 text-green-800
                                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-2">
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </p>
                                    <p class="text-xl font-semibold text-gray-900">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    @if (in_array($order->status, ['pending', 'paid']))
                                        <button wire:click="cancelOrder({{ $order->id }})" 
                                                class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-xl font-medium transition-colors duration-200 border border-red-200"
                                                title="Batalkan Order">
                                            <i class="ri-close-line text-sm mr-1"></i>
                                            Cancel
                                        </button>
                                    @endif

                                    <button wire:click="toggleDetail({{ $order->id }})" 
                                            class="px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-xl font-medium transition-colors duration-200"
                                            title="Detail Order">
                                        <i class="ri-eye-line text-sm mr-1"></i>
                                        {{ $showDetailId === $order->id ? 'Tutup' : 'Detail' }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if ($showDetailId === $order->id)
                            <div class="border-t border-gray-100 bg-gray-50">
                                <div class="p-6">
                                    <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                        <i class="ri-shopping-bag-line text-xl mr-2"></i>
                                        Detail Produk
                                    </h4>
                                    
                                    <div class="space-y-4">
                                        @foreach ($order->items as $item)
                                            <div class="bg-white rounded-xl p-4 border border-gray-200">
                                                <div class="flex items-start space-x-4">
                                                    
                                                    <div class="flex-shrink-0">
                                                        <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden">
                                                            @if ($item->product && $item->product->image)
                                                                <img src="{{ $item->product->image }}" 
                                                                     alt="{{ $item->product->product_name ?? 'Produk' }}" 
                                                                     class="w-full h-full object-cover">
                                                            @else
                                                                <div class="w-full h-full flex items-center justify-center">
                                                                    <i class="ri-image-line text-xl text-gray-400"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="flex-grow min-w-0">
                                                        <h5 class="font-medium text-gray-900 mb-2">
                                                            {{ $item->product->product_name ?? 'Produk tidak ditemukan' }}
                                                        </h5>
                                                        
                                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm text-gray-600">
                                                            <div>
                                                                <span class="block text-gray-500">Harga Satuan</span>
                                                                <span class="font-medium text-gray-900">
                                                                    Rp {{ number_format($item->product_price, 0, ',', '.') }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span class="block text-gray-500">Jumlah</span>
                                                                <span class="font-medium text-gray-900">{{ $item->qty }} pcs</span>
                                                            </div>
                                                            <div class="col-span-2">
                                                                <span class="block text-gray-500">Subtotal</span>
                                                                <span class="font-semibold text-gray-900 text-base">
                                                                    Rp {{ number_format($item->product_price * $item->qty, 0, ',', '.') }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-6 pt-4 border-t border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-medium text-gray-900">Total Pembayaran</span>
                                            <span class="text-xl font-semibold text-gray-900">
                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>