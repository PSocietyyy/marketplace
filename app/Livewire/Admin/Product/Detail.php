<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.admin")]
#[Title("Detail Produk")]
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
        return view('livewire.admin.product.detail');
    }
}
