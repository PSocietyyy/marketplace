<?php

namespace App\Livewire\Home;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Umkn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $this->umknRekomendasi = Umkn::with(['user'])
            ->withSum(['order_items as total_product_terjual' => function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('status', 'completed');
                });
            }], 'qty')
            ->orderByDesc('total_product_terjual')
            ->take(5)
            ->get();


            $min_rating = 3.5;
            $this->produkTerlaris = Product::with(['umkn', 'category'])
                ->select('products.*', DB::raw('SUM(order_items.qty) as total_sold'))
                ->join('order_items', 'products.id', '=', 'order_items.product_id')
                ->groupBy('products.id')
                ->withCount([ // ngitung total review
                    'reviews as total_reviews' => function ($q) {
                        $q->whereNull('parent_id');
                    }
                ])
                ->withAvg([ // rata rata rating
                    'reviews as average_rating' => function ($q) {
                        $q->whereNull('parent_id');
                    }
                ], 'rating')
                ->having('average_rating', '>=', $min_rating) // rating minimal
                ->orderByDesc('total_sold')
                ->take(5)
                ->get();
    }

    public function productDetail($id)
    {
        return redirect()->route('home.product.detail', $id);
    }

    public function addToCart($productId)
    {
        try {
            DB::beginTransaction();

            $userId = Auth::id();

            // Cari cart item user dan produk
            $cart = Cart::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->first();

            // Ambil stok produk
            $product = Product::find($productId);
            if (!$product) {
                $this->dispatch("alert", message: "Produk tidak ditemukan", type: "error");
                DB::rollBack();
                return;
            }

            if ($cart) {
                // Jika sudah ada, tambah qty tapi jangan melebihi stok
                if ($cart->qty < $product->stock) {
                    $cart->qty += 1;
                    $cart->save();
                } else {
                    $this->dispatch("alert", message: "Stok produk tidak mencukupi", type: "error");
                    DB::rollBack();
                    return;
                }
            } else {
                // Jika belum ada, buat baru dengan qty 1
                if ($product->stock < 1) {
                    $this->dispatch("alert", message: "Produk sedang habis stok", type: "error");
                    DB::rollBack();
                    return;
                }
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'qty' => 1,
                ]);
            }

            DB::commit();

            $this->dispatch("alert", message: "Berhasil menambahkan keranjang", type: "success");
            $this->dispatch('cartUpdated');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch("alert", message: "Terjadi kesalahan: " . $e->getMessage(), type: "error");
        }
    }

    public function render()
    {
        return view('livewire.home.index');
    }
}
