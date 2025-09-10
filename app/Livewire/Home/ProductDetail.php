<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Product;
use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Layout("layouts.home")]
#[Title("Detail Produk")]
class ProductDetail extends Component
{
    public $productId;
    public $product;
    public $qty = 1;
    
    // Review properties
    public $rating = 5;
    public $comment = '';
    public $replyComment = '';
    public $replyingTo = null;
    public $showReviewForm = false;
    
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

    public function canUserReview()
    {
        if (!Auth::check()) {
            return false;
        }

        // Check if user has purchased this product
        $hasPurchased = OrderItem::whereHas('order', function($query) {
            $query->where('user_id', Auth::id())
                  ->where('status', 'completed'); // Only completed orders
        })->where('product_id', $this->productId)->exists();

        if (!$hasPurchased) {
            return false;
        }

        // Check if user already reviewed this product
        $hasReviewed = Review::where('user_id', Auth::id())
                           ->where('product_id', $this->productId)
                           ->whereNull('parent_id') // Only main reviews, not replies
                           ->exists();

        return !$hasReviewed;
    }

    public function toggleReviewForm()
    {
        $this->showReviewForm = !$this->showReviewForm;
        if (!$this->showReviewForm) {
            $this->resetReviewForm();
        }
    }

    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:3|max:1000',
        ], [
            'rating.required' => 'Rating harus dipilih',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'comment.required' => 'Komentar harus diisi',
            'comment.min' => 'Komentar minimal 3 karakter',
            'comment.max' => 'Komentar maksimal 1000 karakter',
        ]);

        if (!$this->canUserReview()) {
            $this->dispatch('alert', message: 'Anda tidak dapat memberikan review untuk produk ini', type: 'error');
            return;
        }

        try {
            Review::create([
                'user_id' => Auth::id(),
                'product_id' => $this->productId,
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);

            $this->resetReviewForm();
            $this->showReviewForm = false;
            $this->dispatch('alert', message: 'Review berhasil ditambahkan', type: 'success');
            
        } catch (\Exception $e) {
            $this->dispatch('alert', message: 'Terjadi kesalahan: ' . $e->getMessage(), type: 'error');
        }
    }

    public function replyTo($reviewId)
    {
        $this->replyingTo = $reviewId;
        $this->replyComment = '';
    }

    public function cancelReply()
    {
        $this->replyingTo = null;
        $this->replyComment = '';
    }

    public function submitReply()
    {
        $this->validate([
            'replyComment' => 'required|string|min:3|max:500',
        ], [
            'replyComment.required' => 'Balasan harus diisi',
            'replyComment.min' => 'Balasan minimal 3 karakter',
            'replyComment.max' => 'Balasan maksimal 500 karakter',
        ]);

        if (!Auth::check()) {
            $this->dispatch('alert', message: 'Silakan login terlebih dahulu', type: 'error');
            return;
        }

        try {
            Review::create([
                'user_id' => Auth::id(),
                'product_id' => $this->productId,
                'parent_id' => $this->replyingTo,
                'comment' => $this->replyComment,
            ]);

            $this->cancelReply();
            $this->dispatch('alert', message: 'Balasan berhasil ditambahkan', type: 'success');
            
        } catch (\Exception $e) {
            $this->dispatch('alert', message: 'Terjadi kesalahan: ' . $e->getMessage(), type: 'error');
        }
    }

    public function resetReviewForm()
    {
        $this->rating = 5;
        $this->comment = '';
    }

    public function getReviews()
    {
        return Review::with(['user', 'replies.user'])
                    ->where('product_id', $this->productId)
                    ->whereNull('parent_id')
                    ->latest()
                    ->get();
    }

    public function getAverageRating()
    {
        return Review::where('product_id', $this->productId)
                    ->whereNull('parent_id')
                    ->avg('rating') ?: 0;
    }

    public function getTotalReviews()
    {
        return Review::where('product_id', $this->productId)
                    ->whereNull('parent_id')
                    ->count();
    }

    public function render()
    {
        return view('livewire.home.product-detail', [
            'reviews' => $this->getReviews(),
            'averageRating' => $this->getAverageRating(),
            'totalReviews' => $this->getTotalReviews(),
        ]);
    }
}