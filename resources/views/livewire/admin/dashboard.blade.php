<div class="min-h-screen bg-gray-50">
    {{-- Header Section --}}
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                    <p class="text-gray-600 mt-1">Selamat datang! Berikut ringkasan sistem secara keseluruhan.</p>
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

    {{-- Filters Section --}}
    <div class="px-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Data</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">UMKN</label>
                    <select wire:model.live="selectedUmkn" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($umknOptions as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Order</label>
                    <select wire:model.live="selectedStatus" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Stats Cards --}}
    <div class="px-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total UMKN --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total UMKN</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalUmkns) }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-sm text-gray-500">UMKN terdaftar</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="ri-building-line text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Total Users --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total User</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalUsers) }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-sm text-gray-500">
                                Bukan umkn/admin
                            </span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i class="ri-user-line text-indigo-600 text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Total Products --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Produk</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalProducts) }}</p>
                        <div class="flex items-center mt-2">
                            @if($lowStockProducts > 0)
                                <span class="text-sm text-red-600">
                                    <i class="ri-alert-line mr-1"></i>
                                    {{ $lowStockProducts }} stok rendah
                                </span>
                            @else
                                <span class="text-sm text-green-600">
                                    <i class="ri-check-line mr-1"></i>
                                    Stok aman
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="ri-store-line text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Total Orders --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalOrders) }}</p>
                        <div class="flex items-center mt-2">
                            @if($pendingOrders > 0)
                                <span class="text-sm text-yellow-600">
                                    <i class="ri-time-line mr-1"></i>
                                    {{ $pendingOrders }} pending lama
                                </span>
                            @else
                                <span class="text-sm text-gray-500">
                                    Tidak ada pending lama
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="ri-shopping-bag-3-line text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Secondary Stats --}}
    <div class="px-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Revenue Card --}}
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Revenue</p>
                        <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        <p class="text-green-100 text-sm mt-2">Dari order yang selesai</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="ri-money-dollar-circle-line text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            {{-- Order Status Breakdown --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Pesanan</h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach(['pending', 'processing', 'completed', 'cancelled'] as $status)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $orderStatusStats[$status] ?? 0 }}</div>
                            <div class="text-sm text-gray-600">{{ $this->getStatusText($status) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Charts and Lists Grid --}}
    <div class="px-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Recent Orders --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-900">Pesanan Terbaru</h2>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
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
                                            <h4 class="font-medium text-gray-900">Order #{{ $order->id }}</h4>
                                            <p class="text-sm text-gray-600">
                                                {{ $order->user->getFullName() ?? 'Guest' }}
                                                @if($order->items->first()?->product?->umkn)
                                                    • {{ $order->items->first()->product->umkn->umkn_name }}
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $order->created_at->diffForHumans() }} • {{ $order->items->count() }} item(s)
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

        {{-- Top Products & Top UMKN --}}
        <div class="space-y-8">
            {{-- Top Products --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900">Produk Terlaris</h2>
                </div>
                <div class="p-6">
                    @if($topProducts->count() > 0)
                        <div class="space-y-4">
                            @foreach($topProducts->take(5) as $index => $product)
                                <div class="flex items-center space-x-4">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-600">{{ $index + 1 }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 truncate">{{ $product->product_name }}</h4>
                                        <p class="text-sm text-gray-500">
                                            {{ $product->umkn->umkn_name }} • {{ $product->total_qty ?? 0 }} terjual
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

            {{-- Top UMKN --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900">Top UMKN</h2>
                </div>
                <div class="p-6">
                    @if($topUmkns->count() > 0)
                        <div class="space-y-4">
                            @foreach($topUmkns->take(5) as $index => $umkn)
                                <div class="flex items-center space-x-4">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <span class="text-sm font-medium text-purple-600">{{ $index + 1 }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 truncate">{{ $umkn->umkn_name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $umkn->total_orders ?? 0 }} pesanan</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-900">
                                            Rp {{ number_format($umkn->total_revenue ?? 0, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="ri-building-line text-3xl text-gray-300 mb-2"></i>
                            <p class="text-gray-500 text-sm">Belum ada data UMKN</p>
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
                    <h2 class="text-xl font-semibold text-gray-900">Statistik 12 Bulan Terakhir</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-12 gap-2">
                        @foreach($monthlyStats as $stat)
                            <div class="text-center">
                                <div class="h-32 flex items-end justify-center mb-2">
                                    <div class="bg-blue-100 rounded-t-lg w-6 transition-all duration-500 hover:bg-blue-200" 
                                         style="height: {{ $stat['orders'] > 0 ? max(($stat['orders'] / $monthlyStats->max('orders')) * 100, 10) : 10 }}%">
                                    </div>
                                </div>
                                <div class="text-xs font-medium text-gray-900">{{ explode(' ', $stat['month'])[0] }}</div>
                                <div class="text-xs text-gray-500">{{ $stat['orders'] }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ number_format($stat['revenue'] / 1000000, 1) }}M
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Loading State --}}
    <div wire:loading wire:target="refreshData,selectedUmkn,selectedStatus" 
         class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 flex items-center space-x-4 shadow-2xl">
            <i class="ri-loader-line animate-spin text-2xl text-gray-600"></i>
            <span class="text-gray-700 font-medium">Memperbarui data...</span>
        </div>
    </div>
</div>