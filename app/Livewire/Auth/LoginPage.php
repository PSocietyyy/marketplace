<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.app")]
#[Title("Login")]
class LoginPage extends Component
{
    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
