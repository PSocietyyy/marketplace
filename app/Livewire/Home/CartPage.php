<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

#[Layout("layouts.home")]
#[Title("Keranjang")]
class CartPage extends Component
{
    public $carts = [];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $userId = Auth::id();

        $this->carts = Cart::with('product')
            ->where('user_id', $userId)
            ->get()
            ->map(function ($cart) {
                return [
                    'id' => $cart->id,
                    'product_id' => $cart->product_id,
                    'qty' => $cart->qty,
                    'product_name' => $cart->product->product_name ?? 'Produk tidak ditemukan',
                    'price' => $cart->product->price ?? 0,
                    'image' => $cart->product->image ?? null,
                    'stock' => $cart->product->stock ?? 0,
                ];
            })->toArray();
    }

    public function incrementQty($cartId)
    {
        $cart = Cart::find($cartId);
        // Jika product ditemukan, dan product quantity masih kurang dari stok product
        if ($cart && $cart->qty < $cart->product->stock) {
            $cart->qty++;
            $cart->save();
            $this->loadCart();
        }
    }

    public function decrementQty($cartId)
    {
        $cart = Cart::find($cartId);
        // Jika product ditemukan, dan product quantity harus lebih dari 1
        if ($cart && $cart->qty > 1) {
            $cart->qty--;
            $cart->save();
            $this->loadCart();
        }
    }

    public function removeItem($cartId)
    {
        $cart = Cart::find($cartId);
        if ($cart) {
            $cart->delete();
            $this->loadCart();
        }
    }

    public function checkout()
    {
        // Logika checkout (misal redirect ke halaman pembayaran)
        session()->flash('message', 'Checkout berhasil! (Implementasi selanjutnya)');
        // Contoh redirect:
        // return redirect()->route('checkout.page');
    }

    public function render()
    {
        $total = collect($this->carts)->sum(fn($item) => $item['price'] * $item['qty']);

        return view('livewire.home.cart-page', [
            'total' => $total,
        ]);
    }
}
