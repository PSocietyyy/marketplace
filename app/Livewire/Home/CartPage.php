<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            Log::warning("Checkout gagal: tidak ada produk yang dipilih", [
                'user_id' => Auth::id(),
                'selected' => $this->selected,
            ]);
            $this->dispatch("alert", message: "Pilih minimal satu product untuk checkout", type: "info");
            return;
        }

        $userId = Auth::id();
        if (!$userId) {
            Log::warning("Checkout gagal: user belum login", [
                'selected' => $this->selected,
            ]);
            return redirect()->route('login');
        }

        $selectedCarts = collect($this->carts)->whereIn('id', $this->selected);

        DB::beginTransaction();

        try {
            // Hitung total harga
            $totalPrice = $selectedCarts->sum(fn($item) => $item['price'] * $item['qty']);

            // Buat order baru
            $order = Order::create([
                'user_id' => $userId,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            Log::info("Order dibuat", [
                'order_id' => $order->id,
                'user_id' => $userId,
                'total_price' => $totalPrice,
            ]);

            foreach ($selectedCarts as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    throw new \Exception("Produk dengan ID {$item['product_id']} tidak ditemukan.");
                }

                if ($product->stock < $item['qty']) {
                    throw new \Exception("Stok produk '{$product->product_name}' tidak mencukupi.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                    'product_price' => $item['price'],
                ]);

                Log::info("Order item dibuat", [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                ]);

                // Update stok
                $product->stock -= $item['qty'];
                $product->save();

                Log::info("Stok produk diperbarui", [
                    'product_id' => $product->id,
                    'sisa_stok' => $product->stock,
                ]);

                // Hapus item dari keranjang
                Cart::find($item['id'])->delete();
                Log::info("Item keranjang dihapus", [
                    'cart_id' => $item['id'],
                    'user_id' => $userId,
                ]);
            }

            DB::commit();

            $this->loadCart();
            $this->selected = [];

            Log::info("Checkout berhasil", [
                'order_id' => $order->id,
                'user_id' => $userId,
            ]);

            // session()->flash('message', "Checkout berhasil! Order ID: {$order->id}");
            $this->dispatch("alert", message: "Checkout berhasil", type: "success");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Checkout gagal", [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // session()->flash('message', 'Checkout gagal: ' . $e->getMessage());
            $this->dispatch("alert", message: "Checkout gagal", type: "error");
        }
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
