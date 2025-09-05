<?php

namespace App\Livewire\Home;

use App\Models\Product;
use App\Models\Umkn;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.home")]
#[Title("Home")]
class Index extends Component
{

    public $umknRekomendasi = [];
    public $produkTerlaris = [];
    
    public function mount()
    {
        $this->umknRekomendasi = Umkn::with(['user'])->get();
        $this->produkTerlaris = Product::with(['umkn', 'category'])->get();
    }

    public function productDetail($id)
    {
        return redirect()->route('home.product.detail', $id);
    }

    public function render()
    {
        return view('livewire.home.index');
    }
}
