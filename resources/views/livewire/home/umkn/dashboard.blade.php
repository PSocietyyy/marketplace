<div class="min-h-screen bg-gray-50">
    {{-- Header Section --}}
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-gray-600 mt-1">Selamat datang kembali! Berikut ringkasan bisnis Anda hari ini.</p>
                </div>
                <div class="flex flex-col items-end gap-2">
                    <button wire:click="refreshData" 
                            class="flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                        <i class="ri-refresh-line mr-2"></i>
                        Refresh
                    </button>
                    <div class="text-sm text-gray-500">
                        Terakhir update: {{ now()->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="px-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Produk --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Produk</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalProducts) }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-sm text-gray-500">
                                Semua produk aktif
                            </span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="ri-store-line text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Total Pesanan --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalOrders) }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-sm text-gray-500">
                                Pesanan yang belum diterima.
                            </span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="ri-shopping-bag-3-line text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Total Revenue --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                        <p class="text-xl font-bold text-gray-900 mt-2">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </p>
                        <div class="flex items-center mt-2">
                            <span class="text-sm text-green-600">
                                <i class="ri-arrow-up-line mr-1"></i>
                                Pesanan selesai
                            </span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i class="ri-money-dollar-circle-line text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Stok Rendah --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Stok Rendah</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($lowStockProducts) }}</p>
                        <div class="flex items-center mt-2">
                            @if($lowStockProducts > 0)
                                <span class="text-sm text-red-600">
                                    <i class="ri-alert-line mr-1"></i>
                                    Perlu restok
                                </span>
                            @else
                                <span class="text-sm text-gray-500">
                                    <i class="ri-check-line mr-1"></i>
                                    Stok aman
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="ri-alert-line text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="px-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Recent Orders --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-900">Pesanan Terbaru</h2>
                        <a href="{{ route('home.order') }}" 
                           class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="ri-shopping-bag-line text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">
                                                Order #{{ $order->id }}
                                            </h4>
                                            <p class="text-sm text-gray-600">
                                                {{ $order->user->first_name . " " . $order->user->last_name ?? 'Guest' }} • 
                                                {{ $order->items->count() }} item(s)
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $order->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $this->getStatusBadgeClass($order->status) }}">
                                            {{ $this->getStatusText($order->status) }}
                                        </span>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="ri-shopping-bag-line text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Belum ada pesanan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Top Products & Category Stats --}}
        <div class="space-y-8">
            {{-- Top Products --}}
            <div class="bg-white rounded-2xl h-full shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900">Produk Terlaris</h2>
                </div>
                <div class="p-6">
                    @if($topProducts->count() > 0)
                        <div class="space-y-4">
                            @foreach($topProducts as $index => $product)
                                <div class="flex items-center space-x-4">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-600">{{ $index + 1 }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 truncate">
                                            {{ $product->product_name }}
                                        </h4>
                                        <p class="text-sm text-gray-500">
                                            {{ $product->total_qty ?? 0 }} terjual
                                        </p>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="ri-trophy-line text-3xl text-gray-300 mb-2"></i>
                            <p class="text-gray-500 text-sm">Belum ada data penjualan</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- Monthly Stats Chart --}}
    @if($monthlyStats->count() > 0)
        <div class="px-6 mt-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900">Statistik 6 Bulan Terakhir</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-6 gap-4">
                        @foreach($monthlyStats as $stat)
                            <div class="text-center">
                                <div class="h-32 flex items-end justify-center mb-2">
                                    <div class="bg-blue-100 rounded-t-lg w-8 transition-all duration-500 hover:bg-blue-200" 
                                         style="height: {{ $stat['orders'] > 0 ? max(($stat['orders'] / $monthlyStats->max('orders')) * 100, 10) : 10 }}%">
                                    </div>
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ $stat['month'] }}</div>
                                <div class="text-xs text-gray-500">{{ $stat['orders'] }} pesanan</div>
                                <div class="text-xs text-gray-400">
                                    Rp {{ number_format($stat['revenue'] / 1000, 0) }}k
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Loading State --}}
    <div wire:loading wire:target="refreshData" 
         class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 flex items-center space-x-4 shadow-2xl">
            <i class="ri-loader-line animate-spin text-2xl text-gray-600"></i>
            <span class="text-gray-700 font-medium">Memperbarui data...</span>
        </div>
    </div>
</div>