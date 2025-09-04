<?php

namespace App\Livewire\Landing;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.app")]
#[Title("Landing Page")]
class LandingPage extends Component
{
    public function render()
    {
        return view('livewire.landing.landing-page');
    }
}
