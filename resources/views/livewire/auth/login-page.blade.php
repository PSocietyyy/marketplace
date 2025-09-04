<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
        <a href="{{ route('home') }}" class="text-black hover:underline underline-offset-2"><i class="ri-arrow-left-line"></i> Kembali</a>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Masuk ke Akun Anda
        </h2>

        <form method="POST" wire:submit.prevent='login' class="mt-8 space-y-6" novalidate>
            @csrf

            {{-- Email --}}
            <x-input 
                type="email" 
                name="email" 
                label="Email" 
                wire:model='email'
                placeholder="Masukkan email anda" 
                required 
                :error="$errors->first('email')" 
                value="{{ old('email') }}"
                autofocus
            />

            {{-- Password --}}
            <x-input 
                type="password" 
                name="password" 
                label="Password" 
                wire:model='password'
                placeholder="Masukkan password anda" 
                required 
                :error="$errors->first('password')" 
            />

            {{-- Remember Me --}}
            <div class="flex items-center">
                <input id="remember_me" wire:model='remember' name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                    Ingat saya
                </label>
            </div>

            {{-- Submit Button --}}
            <div>
                <x-button type="submit" variant="primary" size="lg" fullWidth="true" icon="ri-login-box-line" iconPosition="right">
                    Masuk
                </x-button>
            </div>

            {{-- Link to Register --}}
            <p class="mt-4 text-center text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Daftar sekarang
                </a>
            </p>
        </form>
    </div>
</div>