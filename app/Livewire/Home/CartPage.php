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
    public $selected = [];

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

        // Jika belum ada selected, default pilih semua produk
        if (empty($this->selected)) {
            $this->selected = array_column($this->carts, 'id');
        }
    }

    public function updatedSelected()
    {
        // Bisa ditambahkan validasi jika perlu
    }

    public function incrementQty($cartId)
    {
        $cart = Cart::find($cartId);
        if ($cart && $cart->qty < $cart->product->stock) {
            $cart->qty++;
            $cart->save();
            $this->loadCart();
        }
    }

    public function decrementQty($cartId)
    {
        $cart = Cart::find($cartId);
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

            // Hapus dari selected jika ada
            if (($key = array_search($cartId, $this->selected)) !== false) {
                unset($this->selected[$key]);
                $this->selected = array_values($this->selected);
            }
        }
    }

    public function checkout()
    {
        if (empty($this->selected)) {
            session()->flash('message', 'Pilih minimal satu produk untuk checkout.');
            return;
        }

        // Contoh logika checkout hanya untuk produk yang dipilih
        $selectedCarts = collect($this->carts)->whereIn('id', $this->selected);

        // TODO: proses checkout sesuai kebutuhan, misal buat order, kurangi stok, dll

        session()->flash('message', 'Checkout berhasil untuk ' . $selectedCarts->count() . ' produk! (Implementasi selanjutnya)');
    }

    public function render()
    {
        $total = collect($this->carts)
            ->filter(fn($item) => in_array($item['id'], $this->selected))
            ->sum(fn($item) => $item['price'] * $item['qty']);

        return view('livewire.home.cart-page', [
            'total' => $total,
        ]);
    }
}
