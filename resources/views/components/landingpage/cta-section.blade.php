<section class="relative py-14 lg:py-16 overflow-hidden" id="home">
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            <!-- Content Section -->
            <div class="space-y-8">

                <!-- Main Title -->
                <div class="space-y-4">
                    <h2 class="hidden md:block text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                        <span class="block">Bersama UMKM</span>
                        <span class="block bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                            Go Online
                        </span>
                        <span class="block">Go Nasional</span>
                    </h2>

                    <h2 class="md:hidden text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                        <span class="block">Bersama UMKM</span>
                        <span class=" bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                            Go Online
                        </span>
                        <span>Go Nasional</span>
                    </h2>
                    
                    <p class="text-xl text-gray-600 leading-relaxed max-w-2xl">
                        Dari pasar tradisional ke marketplace digital, kini produk UMKM lebih mudah dijangkau.
                    </p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 pt-6">
                    <div class="text-center lg:text-left">
                        <div class="text-2xl lg:text-3xl font-bold text-blue-600">1000+</div>
                        <div class="text-sm text-gray-600 font-medium">UMKM Terdaftar</div>
                    </div>
                    <div class="text-center lg:text-left">
                        <div class="text-2xl lg:text-3xl font-bold text-green-600">50+</div>
                        <div class="text-sm text-gray-600 font-medium">Kota/Kabupaten</div>
                    </div>
                    <div class="text-center lg:text-left">
                        <div class="text-2xl lg:text-3xl font-bold text-purple-600">95%</div>
                        <div class="text-sm text-gray-600 font-medium">Kepuasan</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <x-button 
                        variant="primary" 
                        size="lg"
                        href="#"
                        icon="ri-arrow-right-line"
                        iconPosition="right"
                        class="group"
                    >
                        <span>Mulai Sekarang</span>
                    </x-button>
                </div>

               
            </div>

            <!-- Image Section -->
            <div class="hidden md:block relative lg:order-last">
                <div class="relative">

                    <!-- Main Image Container -->
                    <div class="relative bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
                        <img 
                            src="{{ asset('assets/images/cta.jpg') }}" 
                            alt="UMKM Go Digital Illustration"
                            class="w-full h-auto max-w-md mx-auto"
                            loading="lazy"
                        >

                        <!-- Floating Action Cards -->
                        <div class="absolute -top-3 -right-3 bg-white rounded-lg shadow-lg p-3 border border-gray-200">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-xs font-medium text-gray-700">Online</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bottom Wave -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" class="w-full h-auto">
            <path fill="#ffffff" d="M0,64L48,69.3C96,75,192,85,288,85.3C384,85,480,75,576,69.3C672,64,768,64,864,58.7C960,53,1056,43,1152,42.7C1248,43,1344,53,1392,58.7L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
        </svg>
    </div>
</section>
