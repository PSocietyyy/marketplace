<div x-data="{ sidebarOpen: false }" class="relative">
    <aside 
        x-show="window.innerWidth >= 1024 || sidebarOpen"
        x-transition:enter="transform transition ease-in-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 z-50 w-64 h-screen bg-white border-r border-gray-200 shadow-sm lg:translate-x-0 lg:static lg:z-auto"
        style="display: none;"
        @resize.window="
            if (window.innerWidth >= 1024) {
                sidebarOpen = true   
            } else {
                sidebarOpen = false  
            }
        "
    >
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <h2 class="text-xl font-bold text-gray-900">
                    FRD.<span class="text-gray-500">i</span>
                </h2>
            </div>
            <button @click="sidebarOpen = false" 
                    class="p-1 text-gray-400 hover:text-gray-600 lg:hidden">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>

        {{-- Navigation Menu --}}
        <nav class="mt-6 px-4">
            <ul class="space-y-2">
                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('home.umkn.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('home.umkn.dashboard') ? 'bg-gray-50 text-gray-900' : '' }}">
                        <i class="ri-dashboard-line text-lg mr-3 text-gray-500 group-hover:text-gray-700 {{ request()->routeIs('home.umkn.dashboard') ? 'text-gray-700' : '' }}"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Manajemen Produk --}}
                <li>
                    <a href="{{ route('home.umkn.product.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('home.umkn.product.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                        <i class="ri-store-line text-lg mr-3 text-gray-500 group-hover:text-gray-700 {{ request()->routeIs('home.umkn.product.*') ? 'text-gray-700' : '' }}"></i>
                        <span>Manajemen Produk</span>
                    </a>
                </li>

                {{-- Manajemen Order --}}
                <li>
                    <a href="{{ route('home.umkn.orders') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 group {{ request()->routeIs('home.order') ? 'bg-gray-50 text-gray-900' : '' }}">
                        <i class="ri-list-ordered text-lg mr-3 text-gray-500 group-hover:text-gray-700 {{ request()->routeIs('home.order') ? 'text-gray-700' : '' }}"></i>
                        <span>Manajemen Order</span>
                    </a>
                </li>

                
            </ul>

            
            <div class="space-y-1 bottom-1 absolute">
                {{-- Divider --}}
                <div class="border-t border-gray-200"></div>
                @auth
                    {{-- User Info --}}
                    <div class="px-4 py-2">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                @if (Auth::user()->profile?->photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile?->photo) }}" alt="{{ Auth::user()->name }}">
                                @else
                                    <i class="ri-user-line text-gray-600 text-sm"></i>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->getFullName() }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Auth Buttons untuk guest --}}
                    <div class="px-4 space-y-3">
                        <x-button variant="outline" href="{{ route('register') }}" fullWidth="true" size="sm">
                            <i class="ri-user-add-line mr-2"></i>
                            Daftar
                        </x-button>
                        <x-button variant="primary" href="{{ route('login') }}" fullWidth="true" size="sm">
                            <i class="ri-login-box-line mr-2"></i>
                            Login
                        </x-button>
                    </div>
                @endauth
            </div>
        </nav>
    </aside>

    {{-- Toggle Button untuk Mobile --}}
    <button @click="sidebarOpen = !sidebarOpen" x-show="!sidebarOpen"
            class="fixed top-4 left-4 z-60 p-2 bg-white text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg shadow-md border border-gray-200 lg:hidden transition-colors duration-200"
            aria-label="Toggle sidebar">
        <i class="ri-menu-line text-xl" x-show="!sidebarOpen"></i>
        <i class="ri-close-line text-xl" x-show="sidebarOpen"></i>
    </button>
</div>

{{-- Script untuk handle responsive behavior --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('sidebarData', () => ({
            sidebarOpen: false,
            init() {
                // Handle resize event
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        this.sidebarOpen = false;
                    }
                });
            }
        }));
    });
</script>