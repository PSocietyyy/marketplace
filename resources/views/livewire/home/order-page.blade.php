<div class="min-h-screen bg-white text-black px-6 py-8 max-w-6xl mx-auto">

    <h1 class="text-3xl font-bold mb-6 border-b border-gray-300 pb-2">Daftar Order Saya</h1>

    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-900 rounded">
            {{ session('message') }}
        </div>
    @endif

    {{-- Filter Status --}}
    <div class="mb-6 flex items-center space-x-4">
        <label for="statusFilter" class="font-semibold">Filter Status:</label>
        <select id="statusFilter" wire:model="statusFilter" class="border border-gray-400 rounded px-3 py-1 bg-white text-black">
            <option value="all">Semua</option>
            <option value="pending">Pending</option>
            <option value="paid">Paid</option>
            <option value="shipped">Shipped</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    @if ($orders->isEmpty())
        <div class="text-center py-20 text-gray-500">
            <i class="ri-file-list-line text-7xl mb-6"></i>
            <p class="text-xl font-semibold mb-2">Belum ada order</p>
            <p>Mulai belanja dan buat order pertama Anda.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($orders as $order)
                <div class="flex flex-col bg-white text-black rounded-xl shadow-md overflow-hidden border border-gray-200">
                    <div class="flex items-center px-6 py-4 space-x-6">
                        <div class="flex-grow">
                            <p class="font-semibold text-lg">Order #{{ $order->id }}</p>
                            <p class="text-sm text-gray-600">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
                            <p class="mt-1">Status: 
                                <span class="font-semibold capitalize 
                                    @if($order->status === 'pending') text-yellow-500 
                                    @elseif($order->status === 'paid') text-blue-600 
                                    @elseif($order->status === 'shipped') text-indigo-600 
                                    @elseif($order->status === 'completed') text-green-600 
                                    @elseif($order->status === 'cancelled') text-red-600 
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </p>
                            <p class="mt-1 font-semibold text-lg">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>

                        <div class="flex items-center space-x-4">
                            @if (in_array($order->status, ['pending', 'paid']))
                                <button wire:click="cancelOrder({{ $order->id }})" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold transition-colors duration-200"
                                        title="Batalkan Order">
                                    Cancel
                                </button>
                            @endif

                            <button wire:click="toggleDetail({{ $order->id }})" 
                                    class="bg-black text-white px-4 py-2 rounded font-semibold hover:bg-gray-800 transition-colors duration-200"
                                    title="Detail Order">
                                {{ $showDetailId === $order->id ? 'Tutup Detail' : 'Detail' }}
                            </button>
                        </div>
                    </div>

                    @if ($showDetailId === $order->id)
                        <div class="bg-gray-50 text-black px-6 py-4 border-t border-gray-200">
                            <h3 class="font-semibold mb-3">Detail Produk:</h3>
                            <div class="space-y-3">
                                @foreach ($order->items as $item)
                                    <div class="flex items-center space-x-4 border-b border-gray-200 pb-3">
                                        <div class="w-20 h-20 bg-gray-100 flex items-center justify-center rounded overflow-hidden">
                                            @if ($item->product && $item->product->image)
                                                <img src="{{ $item->product->image }}" alt="{{ $item->product->product_name ?? 'Produk' }}" class="object-cover w-full h-full">
                                            @else
                                                <i class="ri-image-line text-3xl text-gray-400"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow">
                                            <p class="font-semibold">{{ $item->product->product_name ?? 'Produk tidak ditemukan' }}</p>
                                            <p>Harga: Rp {{ number_format($item->product_price, 0, ',', '.') }}</p>
                                            <p>Qty: {{ $item->qty }}</p>
                                            <p>Subtotal: Rp {{ number_format($item->product_price * $item->qty, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>