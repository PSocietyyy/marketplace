<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.app")]
#[Title("Login")]
class LoginPage extends Component
{
    public $email, $password, $remember = false;

    protected $validate = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    protected $messages = [
        "email.required" => "Email harus diisi",
        "email.email" => "Email tidak valid",
        "password.required" => "Password harus diisi",
    ];

    public function login()
    {
        $this->validate();

        if(Auth::attempt(["email" => $this->email, "password" => $this->password], $this->remember)) {
            return redirect()->route("home.index");
        }

        $this->dispatch("error", "Email atau password salah");

        return;
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
