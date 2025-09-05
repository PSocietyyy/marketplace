<?php

namespace App\Livewire\Auth;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.app")]
#[Title("Register")]
class RegisterPage extends Component
{
    public $first_name, $last_name, $email, $birth_date, $number_phone, $password, $password_confirmation;

    protected $rules = [
        "first_name" => "required|string",
        "last_name" => "nullable|string",
        "email" => "required|email|unique:users,email",
        "birth_date" => "required|date|before:today",
        "number_phone" => "required|string|max:13",
        "password" => "required|string|min:6|confirmed",
    ];

    protected $messages = [
        "first_name.required" => "Nama depan wajib diisi",
        "email.required" => "Email wajib diisi",
        "email.email" => "Email tidak valid",
        "email.unique" => "Email sudah terdaftar",
        "birth_date.required" => "Tanggal lahir wajib diisi",
        "birth_date.before" => "Tanggal lahir tidak boleh melebihi tanggal sekarang",
        "number_phone.required" => "Nomor telepon wajib diisi",
        "number_phone.max" => "Nomor telepon terlalu panjang",
        "password.required" => "Password wajib diisi",
        "password.min" => "Password minimal 6 karakter",
        "password.confirmed" => "Password tidak cocok",
    ];

    public function register() 
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $user = User::create([
                "first_name" => $this->first_name,
                "last_name" => $this->last_name,
                "email" => $this->email,
                "birth_date" => $this->birth_date,
                "password" => bcrypt($this->password),
                "role" => "user"
            ]);

            Profile::create([
                "user_id" => $user->id,
                "number_phone" => $this->number_phone
            ]);

            DB::commit();

            Log::info("User register", [
                "email" => $this->email,
            ]);

        } catch(\Exception $e) {
            DB::rollBack();
            $this->dispatch("alert", message: "Terjadi kesalahan!", type: "error");

            Log::error("Register user error", [
                "error" => $e->getMessage()
            ]);

            return;
        }

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
