<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
        <a href="{{ route('home') }}" class="text-black hover:underline underline-offset-2 flex items-center gap-1">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Buat Akun Baru
        </h2>

        <form wire:submit.prevent='register' class="mt-8 space-y-6" novalidate>
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input 
                    type="text" 
                    name="first_name" 
                    label="Nama Depan" 
                    wire:model='first_name'
                    placeholder="Nama depan" 
                    required 
                    :error="$errors->first('first_name')" 
                    value="{{ old('first_name') }}"
                    autofocus
                />
                <x-input 
                    type="text" 
                    name="last_name" 
                    wire:model='last_name'
                    label="Nama Belakang" 
                    placeholder="Nama belakang" 
                    :error="$errors->first('last_name')" 
                    value="{{ old('last_name') }}"
                />
            </div>

            <x-input 
                type="email" 
                name="email" 
                wire:model='email'
                label="Email" 
                placeholder="you@example.com" 
                required 
                :error="$errors->first('email')" 
                value="{{ old('email') }}"
            />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input
                    type="date"
                    name="birth_date"
                    wire:model='birth_date'
                    label="Tanggal Lahir"
                    placeholder="Tanggal Lahir"
                    required
                    :error="$errors->first('birth_date')"
                    value="{{ old('birth_date') }}"
                />
                <x-input
                    type="text"
                    name="number_phone"
                    wire:model='number_phone'
                    label="Nomor Telepon"
                    placeholder="Nomor Telepon"
                    required
                    :error="$errors->first('number_phone')"
                    value="{{ old('number_phone') }}"
                />
            </div>

            <x-input 
                type="password" 
                name="password" 
                wire:model='password'
                label="Password" 
                placeholder="Minimal 8 karakter" 
                required 
                :error="$errors->first('password')" 
            />

            <x-input 
                type="password" 
                wire:model='password_confirmation'
                name="password_confirmation" 
                label="Konfirmasi Password" 
                placeholder="Ulangi password Anda" 
                required 
            />

            {{-- Submit Button --}}
            <div>
                <x-button type="submit" variant="primary" size="lg" fullWidth="true" icon="ri-user-add-line" iconPosition="right">
                    Daftar
                </x-button>
            </div>

            {{-- Link to Login --}}
            <p class="mt-4 text-center text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Masuk di sini
                </a>
            </p>
        </form>
    </div>
</div>