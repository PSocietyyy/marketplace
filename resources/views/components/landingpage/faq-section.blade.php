<section class="relative py-14 lg:py-16 overflow-hidden" id="faq">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="space-y-8 lg:order-last">

            {{-- Hook / Judul --}}
            <div class="space-y-4 text-center">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                    <span class="block">Pertanyaan</span>
                    <span class="block bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                        Yang sering diajukan.
                    </span>
                </h2>
            </div>

            <!-- FAQ Container -->
            <div class="flex flex-wrap gap-4 pt-4 items-start">

                <!-- Pertanyaan 1 -->
                <div class="w-full md:w-[calc(50%-0.5rem)]">
                    <div class="relative w-full" x-data="{ isOpen: false }">
                        <button
                            class="w-full bg-gray-200 font-medium text-gray-800 rounded-lg shadow-lg shadow-gray-100 border border-gray-200 px-3 py-2 flex items-center justify-between"
                            x-on:click="isOpen = !isOpen">
                            Bagaimana cara mendaftar sebagai UMKM?
                            <i :class="`ri-arrow-${isOpen ? 'up' : 'down'}-s-line text-xl`"></i>
                        </button>
                        <div x-show="isOpen" x-transition
                            class="mt-0.5 p-3 bg-white border border-gray-200 rounded-lg shadow">
                            <p class="text-gray-700 text-sm leading-tight">
                                Daftarkan akun terlebih dahulu, lalu buka menu profil dan pilih "Ajukan sebagai UMKM".
                                Setelah itu tunggu persetujuan admin sebelum toko Anda aktif.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Pertanyaan 2 -->
                <div class="w-full md:w-[calc(50%-0.5rem)]">
                    <div class="relative w-full" x-data="{ isOpen: false }">
                        <button
                            class="w-full bg-gray-200 font-medium text-gray-800 rounded-lg shadow-lg shadow-gray-100 border border-gray-200 px-3 py-2 flex items-center justify-between"
                            x-on:click="isOpen = !isOpen">
                            Apakah ada biaya untuk membuka toko?
                            <i :class="`ri-arrow-${isOpen ? 'up' : 'down'}-s-line text-xl`"></i>
                        </button>
                        <div x-show="isOpen" x-transition
                            class="mt-0.5 p-3 bg-white border border-gray-200 rounded-lg shadow">
                            <p class="text-gray-700 text-sm leading-tight">
                                Tidak ada biaya pendaftaran. Anda bisa membuka toko gratis.
                                Hanya ada potongan kecil dari setiap transaksi yang berhasil.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Pertanyaan 3 -->
                <div class="w-full md:w-[calc(50%-0.5rem)]">
                    <div class="relative w-full" x-data="{ isOpen: false }">
                        <button
                            class="w-full bg-gray-200 font-medium text-gray-800 rounded-lg shadow-lg shadow-gray-100 border border-gray-200 px-3 py-2 flex items-center justify-between"
                            x-on:click="isOpen = !isOpen">
                            Bagaimana cara mengatur produk dan stok?
                            <i :class="`ri-arrow-${isOpen ? 'up' : 'down'}-s-line text-xl`"></i>
                        </button>
                        <div x-show="isOpen" x-transition
                            class="mt-0.5 p-3 bg-white border border-gray-200 rounded-lg shadow">
                            <p class="text-gray-700 text-sm leading-tight">
                                Anda bisa menambahkan, mengubah, dan menghapus produk langsung dari dashboard UMKM.
                                Stok akan otomatis berkurang setiap ada pembelian.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Pertanyaan 4 -->
                <div class="w-full md:w-[calc(50%-0.5rem)]">
                    <div class="relative w-full" x-data="{ isOpen: false }">
                        <button
                            class="w-full bg-gray-200 font-medium text-gray-800 rounded-lg shadow-lg shadow-gray-100 border border-gray-200 px-3 py-2 flex items-center justify-between"
                            x-on:click="isOpen = !isOpen">
                            Bagaimana dengan pembayaran dan pencairan dana?
                            <i :class="`ri-arrow-${isOpen ? 'up' : 'down'}-s-line text-xl`"></i>
                        </button>
                        <div x-show="isOpen" x-transition
                            class="mt-0.5 p-3 bg-white border border-gray-200 rounded-lg shadow">
                            <p class="text-gray-700 text-sm leading-tight">
                                Semua pembayaran dari pembeli diproses melalui sistem aman.
                                Dana akan dicairkan ke rekening Anda setelah pesanan selesai (status completed).
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Pertanyaan 5 -->
                <div class="w-full md:w-[calc(50%-0.5rem)]">
                    <div class="relative w-full" x-data="{ isOpen: false }">
                        <button
                            class="w-full bg-gray-200 font-medium text-gray-800 rounded-lg shadow-lg shadow-gray-100 border border-gray-200 px-3 py-2 flex items-center justify-between"
                            x-on:click="isOpen = !isOpen">
                            Apakah produk saya bisa dilihat oleh pembeli dari seluruh Indonesia?
                            <i :class="`ri-arrow-${isOpen ? 'up' : 'down'}-s-line text-xl`"></i>
                        </button>
                        <div x-show="isOpen" x-transition
                            class="mt-0.5 p-3 bg-white border border-gray-200 rounded-lg shadow">
                            <p class="text-gray-700 text-sm leading-tight">
                                Ya! Produk yang Anda jual akan tampil di platform kami dan bisa diakses oleh pembeli
                                dari seluruh wilayah Indonesia.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Pertanyaan 6 -->
                <div class="w-full md:w-[calc(50%-0.5rem)]">
                    <div class="relative w-full" x-data="{ isOpen: false }">
                        <button
                            class="w-full bg-gray-200 font-medium text-gray-800 rounded-lg shadow-lg shadow-gray-100 border border-gray-200 px-3 py-2 flex items-center justify-between"
                            x-on:click="isOpen = !isOpen">
                            Bagaimana jika pesanan dibatalkan?
                            <i :class="`ri-arrow-${isOpen ? 'up' : 'down'}-s-line text-xl`"></i>
                        </button>
                        <div x-show="isOpen" x-transition
                            class="mt-0.5 p-3 bg-white border border-gray-200 rounded-lg shadow">
                            <p class="text-gray-700 text-sm leading-tight">
                                Pesanan hanya bisa dibatalkan jika masih dalam tahap
                                <strong>menunggu konfirmasi</strong> atau <strong>belum diproses</strong>.
                                Jika pesanan sudah dalam tahap <strong>pengiriman</strong>, maka pembatalan tidak dapat dilakukan.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /FAQ Container -->

        </div>
    </div>
</section>
