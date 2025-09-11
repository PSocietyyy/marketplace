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

                    <!-- Stock Badge -->
                    @if ($product->stock > 0)
                        <div class="absolute top-3 left-3">
                            <span class="bg-green-100 text-green-800 text-lg px-2 py-1 rounded-full font-medium">
                                Tersedia
                            </span>
                        </div>
                    @else
                        <div class="absolute top-3 left-3">
                            <span class="bg-red-100 text-red-800 text-lg px-2 py-1 rounded-full font-medium">
                                Habis
                            </span>
                        </div>
                    @endif
                </div>

                <div class="mt-16 grid grid-cols-1 gap-8">
                    <!-- Product Details -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
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
                            <div class="flex justify-between">
                                <span>Rating</span>
                                <div class="flex items-center space-x-2">
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="ri-star{{ $i <= round($averageRating) ? '-fill text-yellow-400' : '-line text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                    <span class="font-medium text-gray-900">{{ number_format($averageRating, 1) }}
                                        ({{ $totalReviews }} ulasan)</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        @if ($product->umkn)
                            <span class="bg-blue-50 text-blue-700 text-sm px-4 py-2 rounded-full font-medium">
                                {{ $product->umkn->umkn_name }}
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

                    @if ($product->stock > 0)
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-medium text-gray-700">Jumlah:</span>
                            <div
                                class="flex items-center bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                                <button wire:click="decrementQty"
                                    class="px-4 py-3 bg-gray-50 hover:bg-gray-100 text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                    @if ($qty <= 1) disabled @endif>
                                    <i class="ri-subtract-line text-lg"></i>
                                </button>
                                <div class="px-6 py-3 bg-white font-semibold text-lg min-w-[4rem] text-center">
                                    {{ $qty }}
                                </div>
                                <button wire:click="incrementQty"
                                    class="px-4 py-3 bg-gray-50 hover:bg-gray-100 text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                    @if ($qty >= $product->stock) disabled @endif>
                                    <i class="ri-add-line text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="bg-gray-100 rounded-2xl p-6 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 font-medium">Subtotal ({{ $qty }} item)</span>
                        <span class="text-2xl font-semibold text-gray-900">
                            Rp {{ number_format($product->price * $qty, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="space-y-4">
                    @if ($product->stock > 0)
                        <button wire:click="addToCart" wire:loading.attr="disabled" wire:target="addToCart"
                        class="w-full bg-gray-900 hover:bg-gray-800 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-medium py-4 rounded-2xl transition duration-200 flex items-center justify-center space-x-3 text-lg">
                        <i class="ri-shopping-cart-line text-xl" wire:loading.class="animate-spin ri-loader-line"
                            wire:target="addToCart"></i>
                        <span wire:loading.remove wire:target="addToCart">Tambah ke Keranjang</span>
                        <span wire:loading wire:target="addToCart">Menambahkan...</span>
                    </button>
                    @else
                        <button wire:loading.attr="disabled"
                        class="w-full bg-gray-500 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-medium py-4 rounded-2xl transition duration-200 flex items-center justify-center space-x-3 text-lg">
                        <i class="ri-shopping-cart-line text-xl"></i>
                        <span wire:loading.remove wire:target="addToCart">Habis</span>
                    </button>
                    @endif
                </div>

            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-16 max-w-4xl mx-auto">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Reviews Header -->
                <div class="px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-medium text-gray-900">Ulasan Pelanggan</h2>
                            <p class="text-gray-600 mt-1">{{ $totalReviews }} ulasan dengan rating rata-rata
                                {{ number_format($averageRating, 1) }}</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="ri-star{{ $i <= round($averageRating) ? '-fill text-yellow-400' : '-line text-gray-300' }} text-xl"></i>
                                @endfor
                            </div>
                            <span
                                class="text-2xl font-bold text-gray-900">{{ number_format($averageRating, 1) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Review Form -->
                @if ($this->canUserReview())
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50">
                        @if (!$showReviewForm)
                            <button wire:click="toggleReviewForm"
                                class="flex items-center space-x-2 bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-xl font-medium transition duration-200">
                                <i class="ri-add-line"></i>
                                <span>Tulis Ulasan</span>
                            </button>
                        @else
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">Tulis Ulasan Anda</h3>
                                    <button wire:click="toggleReviewForm" class="text-gray-500 hover:text-gray-700">
                                        <i class="ri-close-line text-xl"></i>
                                    </button>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                    <div class="flex items-center space-x-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button type="button" wire:click="$set('rating', {{ $i }})"
                                                class="text-2xl {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400 transition-colors">
                                                <i class="ri-star-fill"></i>
                                            </button>
                                        @endfor
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                                    <textarea wire:model="comment" rows="4" placeholder="Bagikan pengalaman Anda dengan produk ini..."
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent resize-none"></textarea>
                                    @error('comment')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center space-x-3">
                                    <button wire:click="submitReview" wire:loading.attr="disabled"
                                        wire:target="submitReview"
                                        class="bg-gray-900 hover:bg-gray-800 disabled:bg-gray-400 text-white px-6 py-2 rounded-xl font-medium transition duration-200">
                                        <span wire:loading.remove wire:target="submitReview">Kirim Ulasan</span>
                                        <span wire:loading wire:target="submitReview">Mengirim...</span>
                                    </button>
                                    <button wire:click="toggleReviewForm"
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-medium transition duration-200">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                @elseif(Auth::check())
                    <div class="px-8 py-4 border-b border-gray-100 bg-yellow-50">
                        <div class="flex items-center space-x-2 text-yellow-700">
                            <i class="ri-information-line"></i>
                            <p class="text-sm">Anda hanya dapat memberikan ulasan setelah membeli produk ini.</p>
                        </div>
                    </div>
                @else
                    <div class="px-8 py-4 border-b border-gray-100 bg-blue-50">
                        <div class="flex items-center space-x-2 text-blue-700">
                            <i class="ri-information-line"></i>
                            <p class="text-sm">Silakan login untuk memberikan ulasan.</p>
                        </div>
                    </div>
                @endif

                <!-- Reviews List -->
                <div class="px-8 py-6">
                    @if ($reviews->count() > 0)
                        <div class="space-y-6">
                            @foreach ($reviews as $review)
                                <div class="border-b border-gray-100 last:border-b-0 pb-6 last:pb-0">
                                    <!-- Main Review -->
                                    <div class="space-y-3">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                    @if ($review->user->profile->photo)
                                                        <img src="{{ asset('storage/' . $review->user->profile->photo) }}"
                                                            alt="{{ $review->user->first_name }}"
                                                            class="rounded-full">
                                                    @else
                                                        <i class="ri-user-line text-gray-600"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">
                                                        {{ $review->user->first_name . ' ' . $review->user->last_name }}
                                                    </p>
                                                    <div class="flex items-center space-x-2">
                                                        <div class="flex items-center">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="ri-star{{ $i <= $review->rating ? '-fill text-yellow-400' : '-line text-gray-300' }} text-sm"></i>
                                                            @endfor
                                                        </div>
                                                        <span
                                                            class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="text-gray-700 ml-13">{{ $review->comment }}</p>

                                        @auth
                                            @if ($replyingTo !== $review->id)
                                                <button wire:click="replyTo({{ $review->id }})"
                                                    class="text-sm text-gray-500 hover:text-gray-700 ml-13">
                                                    Balas
                                                </button>
                                            @endif
                                        @endauth

                                        <!-- Reply Form -->
                                        @if ($replyingTo === $review->id)
                                            <div class="ml-13 mt-3 p-4 bg-gray-50 rounded-xl">
                                                <textarea wire:model="replyComment" rows="3" placeholder="Tulis balasan Anda..."
                                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent resize-none text-sm"></textarea>
                                                @error('replyComment')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                                <div class="flex items-center space-x-2 mt-3">
                                                    <button wire:click="submitReply" wire:loading.attr="disabled"
                                                        wire:target="submitReply"
                                                        class="bg-gray-900 hover:bg-gray-800 disabled:bg-gray-400 text-white px-4 py-1.5 rounded-lg text-sm font-medium transition duration-200">
                                                        <span wire:loading.remove
                                                            wire:target="submitReply">Kirim</span>
                                                        <span wire:loading wire:target="submitReply">Mengirim...</span>
                                                    </button>
                                                    <button wire:click="cancelReply"
                                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-1.5 rounded-lg text-sm font-medium transition duration-200">
                                                        Batal
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Replies -->
                                        @if ($review->replies->count() > 0)
                                            <div class="ml-13 mt-4 space-y-4">
                                                @foreach ($review->replies as $reply)
                                                    <div class="bg-gray-50 p-4 rounded-xl">
                                                        <div class="flex items-start space-x-3">
                                                            <div
                                                                class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center flex-shrink-0">
                                                                @if ($reply->user->profile->photo)
                                                                    <img src="{{ asset('storage/' . $reply->user->profile->photo) }}"
                                                                        alt="{{ $reply->user->first_name }}"
                                                                        class="rounded-full">
                                                                @else
                                                                    <i class="ri-user-line text-gray-600"></i>
                                                                @endif
                                                            </div>
                                                            <div class="flex-1">
                                                                <div class="flex items-center space-x-2">
                                                                    <p class="font-medium text-gray-900 text-sm">
                                                                        {{ $reply->user->first_name . ' ' . $reply->user->last_name }}
                                                                    </p>
                                                                    <span
                                                                        class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                                </div>
                                                                <p class="text-gray-700 text-sm mt-1">
                                                                    {{ $reply->comment }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="ri-chat-3-line text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500">Belum ada ulasan untuk produk ini</p>
                            <p class="text-gray-400 text-sm">Jadilah yang pertama memberikan ulasan!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
