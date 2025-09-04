<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.home")]
#[Title("Home")]
class Index extends Component
{
    public function render()
    {
        return view('livewire.home.index');
    }
}
