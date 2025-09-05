<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Layout("layouts.home")]
#[Title("Detail Produk")]
class ProductDetail extends Component
{
    public $productId;
    public $product;
    public $qty = 1;

    public function mount($id)
    {
        $this->productId = $id;
        $this->loadProduct();
    }

    public function loadProduct()
    {
        $this->product = Product::with(['category', 'umkn'])->findOrFail($this->productId);
    }

    public function incrementQty()
    {
        if ($this->qty < $this->product->stock) {
            $this->qty++;
        }
    }

    public function decrementQty()
    {
        if ($this->qty > 1) {
            $this->qty--;
        }
    }

    public function addToCart()
    {
        try {
            DB::beginTransaction();

            $userId = Auth::id();
            if (!$userId) {
                $this->dispatch('alert', message: 'Silakan login terlebih dahulu', type: 'error');
                DB::rollBack();
                return;
            }

            $cart = \App\Models\Cart::where('user_id', $userId)
                ->where('product_id', $this->productId)
                ->first();

            if ($cart) {
                $newQty = $cart->qty + $this->qty;
                if ($newQty > $this->product->stock) {
                    $this->dispatch('alert', message: 'Stok produk tidak mencukupi', type: 'error');
                    DB::rollBack();
                    return;
                }
                $cart->qty = $newQty;
                $cart->save();
            } else {
                if ($this->qty > $this->product->stock) {
                    $this->dispatch('alert', message: 'Stok produk tidak mencukupi', type: 'error');
                    DB::rollBack();
                    return;
                }
                \App\Models\Cart::create([
                    'user_id' => $userId,
                    'product_id' => $this->productId,
                    'qty' => $this->qty,
                ]);
            }

            DB::commit();

            $this->dispatch('alert', message: 'Berhasil menambahkan ke keranjang', type: 'success');
            $this->dispatch('cartUpdated');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('alert', message: 'Terjadi kesalahan: ' . $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.home.product-detail');
    }
}
