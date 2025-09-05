<?php

namespace App\Livewire\Home;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.home")]
#[Title("Products")]
class ProductPage extends Component
{
    public $products = [];
    public $categories = [];
    
    // Filter properties
    public $search = '';
    public $selectedCategory = '';
    public $priceRange = '';
    public $sortBy = 'newest';
    public $onlyInStock = false;

    public function mount() 
    {
        $this->categories = Category::all();
        $this->loadProducts();
    }

    public function updated($property)
    {
        // Reload products when any filter changes
        if (in_array($property, ['search', 'selectedCategory', 'priceRange', 'sortBy', 'onlyInStock'])) {
            $this->loadProducts();
        }
    }

    public function loadProducts()
    {
        $query = Product::with(['umkn', 'category']);

        // Search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('product_name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('category', function ($categoryQuery) {
                      $categoryQuery->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('umkn', function ($umknQuery) {
                      $umknQuery->where('umkn_name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Category filter
        if (!empty($this->selectedCategory)) {
            $query->where('category_id', $this->selectedCategory);
        }

        // Price range filter
        if (!empty($this->priceRange)) {
            $range = explode('-', $this->priceRange);
            if (count($range) === 2) {
                $minPrice = (int) $range[0];
                $maxPrice = (int) $range[1];
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }
        }

        // Stock filter
        if ($this->onlyInStock) {
            $query->where('stock', '>', 0);
        }

        // Sorting
        switch ($this->sortBy) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('product_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('product_name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $this->products = $query->get();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedCategory = '';
        $this->priceRange = '';
        $this->sortBy = 'newest';
        $this->onlyInStock = false;
        $this->loadProducts();
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
        return view('livewire.home.product-page');
    }
}