<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.app")]
#[Title("Register")]
class RegisterPage extends Component
{
    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
