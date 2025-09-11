<div class="min-h-screen min-w-full bg-gray-50 text-gray-900 px-4 sm:px-6 lg:px-8 py-12 max-w-6xl mx-auto">

    <div class="mb-10">
        <div class="text-center mb-8">
            <h1 class="text-4xl sm:text-5xl font-light mb-3">
                UMKN <span class="text-gray-500 font-extralight">Rekomendasi</span>
            </h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Temukan UMKN terbaik dan produk unggulan yang
                direkomendasikan untuk Anda</p>
        </div>
    </div>

    <div class="mb-10">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-medium text-gray-800 mb-2">UMKN Terbaik</h2>
            <div class="w-16 h-0.5 bg-gray-400 mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($umknRekomendasi as $umkn)
                <div
                    class="bg-white rounded-2xl p-8 text-center shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100">
                    <div class="relative mb-6">
                        <img src="{{ asset('storage/' . $umkn['logo']) }}" alt="{{ $umkn['umkn_name'] }}"
                            class="w-20 h-20 object-cover rounded-full mx-auto ring-4 ring-gray-50">
                    </div>
                    <a href="{{ route('home.profile.umkn', $umkn->id) }}" class="text-xl font-medium mb-3 text-gray-900 hover:underline underline-offset-2">{{ $umkn['umkn_name'] }}</a>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $umkn['description'] }}</p>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        {{ $umkn['total_product_terjual'] > 0 ? $umkn['total_product_terjual'] : 0 }} Produk Terjual</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mb-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-light mb-3">
                Produk <span class="text-gray-500 font-extralight">Terlaris</span>
            </h2>
            <div class="w-16 h-0.5 bg-gray-400 mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($produkTerlaris as $produk)
                <div
                    class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-lg hover:border-gray-200 transition-all duration-300 group">

                    {{-- Thumbnail --}}
                    <div class="relative overflow-hidden cursor-pointer"
                        wire:click='productDetail({{ $produk->id }})'>
                        @if (!empty($produk->image))
                            <img src="{{ str_starts_with($produk->image, 'https') ? $produk->image : asset('storage/' . $produk->image) }}"
                                alt="{{ $produk->product_name }}"
                                class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
                        @else
                            <div
                                class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-150 flex items-center justify-center group-hover:from-gray-200 group-hover:to-gray-250 transition-all duration-300">
                                <i class="ri-image-line text-4xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-5">
                        {{-- Nama produk + kategori/UMKM --}}
                        <div class="mb-4">
                            <h3 class="font-medium text-lg mb-2 text-gray-900 truncate cursor-pointer hover:text-gray-700 transition-colors"
                                wire:click='productDetail({{ $produk->id }})'>
                                {{ $produk->product_name }}
                            </h3>

                            <div class="flex flex-wrap items-center gap-2 mb-3">
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
                                @if (!empty($produk->total_sold))
                                    <span
                                        class="bg-indigo-50 text-indigo-700 text-xs font-medium px-3 py-1 rounded-full">
                                        Terjual: <span
                                            class="text-gray-900 font-semibold">{{ $produk->total_sold }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Deskripsi singkat --}}
                        <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-2">
                            {{ \Illuminate\Support\Str::limit($produk->description, 80) }}
                        </p>

                        {{-- Harga + stok --}}
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xl font-semibold text-gray-900">
                                Rp {{ number_format($produk->price, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-gray-500 bg-gray-50 px-3 py-1 rounded-full">
                                Stok: {{ $produk->stock }}
                            </span>
                        </div>

                        {{-- Rating + jumlah ulasan --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="ri-star{{ $i <= round($produk->average_rating) ? '-fill text-yellow-400' : '-line text-gray-300' }} text-base"></i>
                                @endfor
                                <span class="text-sm text-gray-600">({{ $produk->total_reviews }})</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">
                                {{ number_format($produk->average_rating, 1) }}/5
                            </span>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex gap-3">
                            <button wire:click="addToCart({{ $produk->id }})" wire:loading.attr="disabled"
                                wire:target="addToCart({{ $produk->id }})"
                                class="flex-1 bg-gray-900 hover:bg-gray-800 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-medium py-3 rounded-xl transition duration-200 text-sm">
                                <span wire:loading.remove wire:target="addToCart({{ $produk->id }})">Beli
                                    Sekarang</span>
                                <span wire:loading wire:target="addToCart({{ $produk->id }})">Loading...</span>
                            </button>

                            <button wire:click="addToCart({{ $produk->id }})" wire:loading.attr="disabled"
                                wire:target="addToCart({{ $produk->id }})"
                                class="w-12 h-12 border border-gray-300 hover:bg-gray-900 hover:text-white hover:border-gray-900 text-gray-700 disabled:bg-gray-100 disabled:cursor-not-allowed rounded-xl transition duration-200 flex items-center justify-center">
                                <i class="ri-shopping-cart-line text-lg"
                                    wire:loading.class="animate-spin ri-loader-line"
                                    wire:target="addToCart({{ $produk->id }})"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="max-w-sm mx-auto">
                        <i class="ri-shopping-bag-line text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Produk</h3>
                        <p class="text-gray-600 text-sm">Produk terlaris akan ditampilkan di sini ketika sudah tersedia
                        </p>
                    </div>
                </div>
            @endforelse
        </div>


        <div wire:loading.flex wire:target="addToCart"
            class="fixed inset-0 bg-black bg-opacity-30 items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-8 flex items-center space-x-4 shadow-2xl">
                <i class="ri-loader-line animate-spin text-2xl text-gray-600"></i>
                <span class="text-gray-700 font-medium">Menambahkan ke keranjang...</span>
            </div>
        </div>
    </div>
</div>
