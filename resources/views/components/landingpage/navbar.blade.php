<nav 
    class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-lg border-b border-gray-200/50 shadow-sm"
    x-data="{ mobileMenuOpen: false }"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Brand Logo --}}
            <div class="flex-shrink-0">
                <a href="#" class="flex items-center group">
                    <h1 class="text-2xl font-bold text-gray-900 group-hover:text-gray-700 transition-colors duration-200">
                        FRD.<span class="text-gray-500">i</span>
                    </h1>
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="#home" 
                   class="relative text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-all duration-200 group">
                    Home
                    <span class="absolute inset-x-0 -bottom-px h-px bg-gradient-to-r from-transparent via-gray-900 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-200 "></span>
                </a>
                <a href="#about" 
                   class="relative text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-all duration-200 group">
                    About
                    <span class="absolute inset-x-0 -bottom-px h-px bg-gradient-to-r from-transparent via-gray-900 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-200 "></span>
                </a>
                <a href="#faq" 
                   class="relative text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-all duration-200 group ">
                    Pertanyaan
                    <span class="absolute inset-x-0 -bottom-px h-px bg-gradient-to-r from-transparent via-gray-900 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-200 "></span>
                </a>
            </div>

            {{-- Desktop Auth Buttons --}}
            <div class="hidden md:flex items-center gap-3">
                @auth
                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <i class="ri-user-line text-gray-600"></i>
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="ri-arrow-down-s-line transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                             style="display: none;"
                        >
                            <a href="#" 
                               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <i class="ri-dashboard-line"></i>
                                Dashboard
                            </a>
                            <a href="#" 
                               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <i class="ri-user-settings-line"></i>
                                Profile
                            </a>
                            <hr class="my-1 border-gray-100">
                            <form method="POST" action="#">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                    <i class="ri-logout-box-line"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <x-button variant="ghost" href="{{ route('register') }}" size="sm">
                        Daftar
                    </x-button>
                    <x-button variant="primary" href="{{ route('login') }}" size="sm">
                        Login
                    </x-button>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                        aria-label="Toggle menu">
                    <i class="ri-menu-line text-xl" x-show="!mobileMenuOpen"></i>
                    <i class="ri-close-line text-xl" x-show="mobileMenuOpen"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden bg-white border-t border-gray-200"
         @click.away="mobileMenuOpen = false"
         style="display: none;"
    >
        <div class="px-4 pt-2 pb-3 space-y-1">
            <a href="#home" 
               class="flex items-center px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200 {{ request()->routeIs('home') ? 'text-gray-900 bg-gray-50' : '' }}">
                <i class="ri-home-line mr-3"></i>
                Home
            </a>
            <a href="#about" 
               class="flex items-center px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200 {{ request()->routeIs('about') ? 'text-gray-900 bg-gray-50' : '' }}">
                <i class="ri-information-line mr-3"></i>
                About
            </a>
            <a href="#faq" 
               class="flex items-center px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200 {{ request()->routeIs('contact') ? 'text-gray-900 bg-gray-50' : '' }}">
                <i class="ri-mail-line mr-3"></i>
                Pertanyaan
            </a>
        </div>

        {{-- Mobile Auth Section --}}
        <div class="pt-4 pb-3 border-t border-gray-200">
            @auth
                <div class="px-4 space-y-1">
                    <div class="flex items-center px-3 py-2">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                            <i class="ri-user-line text-gray-600"></i>
                        </div>
                        <div>
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <a href="#" 
                       class="flex items-center px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <i class="ri-dashboard-line mr-3"></i>
                        Dashboard
                    </a>
                    <a href="#" 
                       class="flex items-center px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <i class="ri-user-settings-line mr-3"></i>
                        Profile
                    </a>
                    <form method="POST" action="#">
                        @csrf
                        <button type="submit" 
                                class="flex items-center w-full text-left px-3 py-2 text-base font-medium text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors duration-200">
                            <i class="ri-logout-box-line mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="px-4 space-y-3">
                    <x-button variant="outline" href="#" fullWidth="true">
                        <i class="ri-user-add-line"></i>
                        Daftar
                    </x-button>
                    <x-button variant="primary" href="#" fullWidth="true">
                        <i class="ri-login-box-line"></i>
                        Login
                    </x-button>
                </div>
            @endauth
        </div>
    </div>
</nav>
