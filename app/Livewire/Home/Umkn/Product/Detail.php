<?php

namespace App\Livewire\Home\Umkn\Product;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

#[Layout("layouts.umkn")]
#[Title("Detail Product")]
class Detail extends Component
{
    public Product $product;
    public $showImageModal = false;

    public function mount($id)
    {
        $this->product = Product::with(['category', 'umkn'])->findOrFail($id);
    }

    public function toggleImageModal()
    {
        $this->showImageModal = !$this->showImageModal;
    }

    public function render()
    {
        return view('livewire.home.umkn.product.detail');
    }
}