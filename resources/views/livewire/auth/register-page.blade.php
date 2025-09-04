<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
        <a href="{{ route('home') }}" class="text-black hover:underline underline-offset-2"><i class="ri-arrow-left-line"></i> Kembali</a>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Buat Akun Baru
        </h2>

        <form method="POST" action="#" class="mt-8 space-y-6" novalidate>
            @csrf

            {{-- Name --}}
            <x-input 
                type="text" 
                name="name" 
                label="Nama Lengkap" 
                placeholder="Nama Anda" 
                required 
                :error="$errors->first('name')" 
                value="{{ old('name') }}"
                autofocus
            />

            {{-- Email --}}
            <x-input 
                type="email" 
                name="email" 
                label="Email" 
                placeholder="you@example.com" 
                required 
                :error="$errors->first('email')" 
                value="{{ old('email') }}"
            />

            {{-- Password --}}
            <x-input 
                type="password" 
                name="password" 
                label="Password" 
                placeholder="Minimal 8 karakter" 
                required 
                :error="$errors->first('password')" 
            />

            {{-- Password Confirmation --}}
            <x-input 
                type="password" 
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