<div class="min-h-screen min-w-full bg-gray-50 text-gray-900 px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-4xl mx-auto">
        
        <div class="mb-12">
            <h1 class="text-4xl lg:text-5xl font-light leading-tight mb-2">Profile Saya</h1>
            <p class="text-gray-600">Kelola informasi pribadi dan UMKN Anda</p>
        </div>

        <!-- Personal Information Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                        <i class="ri-user-line text-2xl mr-3"></i>
                        Informasi Pribadi
                    </h2>
                    <button wire:click="toggleEditProfile" 
                            class="px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-xl font-medium transition-colors duration-200">
                        <i class="ri-edit-line text-sm mr-2"></i>
                        {{ $editingProfile ? 'Batal' : 'Edit' }}
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                @if($editingProfile)
                    <!-- Edit Profile Form -->
                    <form wire:submit="updateProfile">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Avatar Upload -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Foto Profile</label>
                                <div class="flex items-center space-x-6">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full overflow-hidden flex-shrink-0">
                                        @if($new_avatar)
                                            <img src="{{ $new_avatar->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">
                                        @elseif($avatar)
                                            <img src="{{ Storage::url($avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="ri-user-line text-2xl text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <input type="file" wire:model="new_avatar" accept="image/*" class="hidden" id="avatar-upload">
                                        <label for="avatar-upload" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium cursor-pointer transition-colors duration-200">
                                            <i class="ri-upload-line text-sm mr-2"></i>
                                            Pilih Foto
                                        </label>
                                        @if($new_avatar)
                                            <button type="button" wire:click="$set('new_avatar', null)" class="ml-2 px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl font-medium transition-colors duration-200">
                                                <i class="ri-close-line text-sm"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                @error('new_avatar') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Depan</label>
                                <input type="text" wire:model="first_name" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                @error('first_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Belakang</label>
                                <input type="text" wire:model="last_name" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                @error('last_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                                <input type="date" wire:model="birth_date" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                @error('birth_date') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" wire:model="email" disabled class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-3 text-gray-500 cursor-not-allowed">
                                <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" wire:model="phone" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                @error('phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <textarea wire:model="address" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent"></textarea>
                                @error('address') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" wire:click="toggleEditProfile" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-colors duration-200">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-xl font-medium transition-colors duration-200">
                                <i class="ri-save-line text-sm mr-2"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                @else
                    <!-- Display Profile Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2 flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gray-100 rounded-full overflow-hidden flex-shrink-0">
                                @if($avatar)
                                    <img src="{{ Storage::url($avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="ri-user-line text-xl text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $full_name ?: $first_name . ' ' . $last_name }}</h3>
                                <p class="text-gray-600">{{ $email }}</p>
                            </div>
                        </div>

                        <div>
                            <span class="block text-sm text-gray-500">Nama Depan</span>
                            <span class="text-gray-900 font-medium">{{ $first_name ?: '-' }}</span>
                        </div>

                        <div>
                            <span class="block text-sm text-gray-500">Nama Belakang</span>
                            <span class="text-gray-900 font-medium">{{ $last_name ?: '-' }}</span>
                        </div>

                        <div>
                            <span class="block text-sm text-gray-500">Tanggal Lahir</span>
                            <span class="text-gray-900 font-medium">{{ $birth_date ? \Carbon\Carbon::parse($birth_date)->format('d M Y') : '-' }}</span>
                        </div>

                        <div>
                            <span class="block text-sm text-gray-500">Nomor Telepon</span>
                            <span class="text-gray-900 font-medium">{{ $phone ?: '-' }}</span>
                        </div>

                        <div class="md:col-span-2">
                            <span class="block text-sm text-gray-500">Alamat</span>
                            <span class="text-gray-900 font-medium">{{ $address ?: '-' }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- UMKN Section -->
        @if(Auth::user()->umkn)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="ri-store-line text-2xl mr-3"></i>
                            Informasi UMKN
                        </h2>
                        <button wire:click="toggleEditUmkn" 
                                class="px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-xl font-medium transition-colors duration-200">
                            <i class="ri-edit-line text-sm mr-2"></i>
                            {{ $editingUmkn ? 'Batal' : 'Edit' }}
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($editingUmkn)
                        <!-- Edit UMKN Form -->
                        <form wire:submit="updateUmkn">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Logo Upload -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Logo UMKN</label>
                                    <div class="flex items-center space-x-6">
                                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                            @if($new_umkn_logo)
                                                <img src="{{ $new_umkn_logo->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">
                                            @elseif($umkn_logo)
                                                <img src="{{ Storage::url($umkn_logo) }}" alt="Logo" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="ri-store-line text-2xl text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <input type="file" wire:model="new_umkn_logo" accept="image/*" class="hidden" id="logo-upload">
                                            <label for="logo-upload" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium cursor-pointer transition-colors duration-200">
                                                <i class="ri-upload-line text-sm mr-2"></i>
                                                Pilih Logo
                                            </label>
                                            @if($new_umkn_logo)
                                                <button type="button" wire:click="$set('new_umkn_logo', null)" class="ml-2 px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl font-medium transition-colors duration-200">
                                                    <i class="ri-close-line text-sm"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    @error('new_umkn_logo') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama UMKN</label>
                                    <input type="text" wire:model="umkn_name" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                    @error('umkn_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                    <textarea wire:model="umkn_description" rows="4" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent"></textarea>
                                    @error('umkn_description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon UMKN</label>
                                    <input type="text" wire:model="umkn_phone" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                    @error('umkn_phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat UMKN</label>
                                    <textarea wire:model="umkn_address" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent"></textarea>
                                    @error('umkn_address') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 mt-6">
                                <button type="button" wire:click="toggleEditUmkn" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-colors duration-200">
                                    Batal
                                </button>
                                <button type="submit" class="px-6 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-xl font-medium transition-colors duration-200">
                                    <i class="ri-save-line text-sm mr-2"></i>
                                    Simpan
                                </button>
                            </div>
                        </form>
                    @else
                        <!-- Display UMKN Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2 flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($umkn_logo)
                                        <img src="{{ Storage::url($umkn_logo) }}" alt="Logo" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="ri-store-line text-xl text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $umkn_name }}</h3>
                                    <p class="text-gray-600">UMKN {{ Auth::user()->umkn->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}</p>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <span class="block text-sm text-gray-500">Deskripsi</span>
                                <p class="text-gray-900 font-medium mt-1">{{ $umkn_description ?: '-' }}</p>
                            </div>

                            <div>
                                <span class="block text-sm text-gray-500">Nomor Telepon UMKN</span>
                                <span class="text-gray-900 font-medium">{{ $umkn_phone ?: '-' }}</span>
                            </div>

                            <div>
                                <span class="block text-sm text-gray-500">Alamat UMKN</span>
                                <span class="text-gray-900 font-medium">{{ $umkn_address ?: '-' }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Create UMKN Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <i class="ri-store-add-line text-2xl mr-3"></i>
                                Bergabung sebagai UMKN
                            </h2>
                            <p class="text-gray-600 mt-1">Daftarkan bisnis Anda dan mulai berjualan</p>
                        </div>
                        @if(!$showCreateUmkn)
                            <button wire:click="toggleCreateUmkn" 
                                    class="px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-xl font-medium transition-colors duration-200">
                                <i class="ri-add-line text-sm mr-2"></i>
                                Daftar UMKN
                            </button>
                        @endif
                    </div>
                </div>
                
                @if($showCreateUmkn)
                    <div class="p-6">
                        <!-- Create UMKN Form -->
                        <form wire:submit="createUmkn">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Logo Upload -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Logo UMKN</label>
                                    <div class="flex items-center space-x-6">
                                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                            @if($new_umkn_logo)
                                                <img src="{{ $new_umkn_logo->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="ri-store-line text-2xl text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <input type="file" wire:model="new_umkn_logo" accept="image/*" class="hidden" id="create-logo-upload">
                                            <label for="create-logo-upload" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium cursor-pointer transition-colors duration-200">
                                                <i class="ri-upload-line text-sm mr-2"></i>
                                                Pilih Logo
                                            </label>
                                            @if($new_umkn_logo)
                                                <button type="button" wire:click="$set('new_umkn_logo', null)" class="ml-2 px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl font-medium transition-colors duration-200">
                                                    <i class="ri-close-line text-sm"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    @error('new_umkn_logo') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama UMKN <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="umkn_name" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent" placeholder="Masukkan nama UMKN Anda">
                                    @error('umkn_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                                    <textarea wire:model="umkn_description" rows="4" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent" placeholder="Deskripsikan bisnis UMKN Anda"></textarea>
                                    @error('umkn_description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon UMKN <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="umkn_phone" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent" placeholder="Contoh: 08123456789">
                                    @error('umkn_phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat UMKN <span class="text-red-500">*</span></label>
                                    <textarea wire:model="umkn_address" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:border-transparent" placeholder="Masukkan alamat lengkap UMKN"></textarea>
                                    @error('umkn_address') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 mt-6">
                                <button type="button" wire:click="toggleCreateUmkn" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-colors duration-200">
                                    Batal
                                </button>
                                <button type="submit" class="px-6 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-xl font-medium transition-colors duration-200">
                                    <i class="ri-save-line text-sm mr-2"></i>
                                    Daftarkan UMKN
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="p-6">
                        <div class="text-center py-8">
                            <div class="w-20 h-20 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                <i class="ri-store-add-line text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Memiliki UMKN</h3>
                            <p class="text-gray-600 mb-4">Daftarkan bisnis Anda sebagai UMKN untuk mulai berjualan dan mengakses berbagai fitur eksklusif.</p>
                            <div class="flex flex-wrap justify-center gap-4 text-sm text-gray-600 mb-6">
                                <div class="flex items-center">
                                    <i class="ri-check-line text-green-500 mr-1"></i>
                                    Kelola produk
                                </div>
                                <div class="flex items-center">
                                    <i class="ri-check-line text-green-500 mr-1"></i>
                                    Terima pesanan
                                </div>
                                <div class="flex items-center">
                                    <i class="ri-check-line text-green-500 mr-1"></i>
                                    Laporan penjualan
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>