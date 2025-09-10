<nav 
    class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-lg border-b border-gray-200/50 shadow-sm"
    x-data="{ mobileMenuOpen: false }"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end items-center h-16">

           

            {{-- Desktop Auth Buttons --}}
            <div class="hidden md:flex items-center gap-3">
                @auth
                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                @if (Auth::user()->profile?->photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile->photo) }}" alt="{{ Auth::user()->name }}">
                                @else
                                    <i class="ri-user-line text-gray-600"></i>
                                @endif
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
                            <a href="{{ route('home.profile') }}" 
                               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <i class="ri-user-settings-line"></i>
                                Profile
                            </a>
                            <hr class="my-1 border-gray-100">
                            <livewire:auth.logout-b-t-n />
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
                    <a href="{{ route('home.profile') }}" 
                       class="flex items-center px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <i class="ri-user-settings-line mr-3"></i>
                        Profile
                    </a>
                    <livewire:auth.logout-b-t-n />
                
                </div>
            @endauth
        </div>
    </div>
</nav>