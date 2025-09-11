<?php

namespace App\Livewire\Home;

use App\Models\Category;
use App\Models\Umkn;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout("layouts.home")]
#[Title("Profile UMKN")]
class UmknProfile extends Component
{
    use WithPagination;

    public $umkn;
    public $categories = [];
    public $totalSold;
    public $averageRating;

    // Filter properties
    public $search = '';
    public $selectedCategory = '';
    public $priceRange = '';
    public $sortBy = 'newest';
    public $onlyInStock = false;

    public function mount($id)
    {
        $this->umkn = Umkn::findOrFail($id);

        $this->categories = Category::whereHas('products', function ($query) {
            $query->where('umkn_id', $this->umkn->id);
        })->get();

        $this->totalSold = $this->umkn->order_items()
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed');
            })
            ->sum('qty');

        $this->averageRating = $this->umkn->products()
            ->with('reviews')
            ->get()
            ->flatMap(fn($product) => $product->reviews)
            ->avg('rating');
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'selectedCategory', 'priceRange', 'sortBy', 'onlyInStock'])) {
            $this->resetPage();
        }
    }

    public function getProductsProperty()
    {
        $query = $this->umkn->products()
            ->with(['category', 'reviews'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        // Search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('product_name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('category', function ($categoryQuery) {
                      $categoryQuery->where('name', 'like', '%' . $this->search . '%');
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

        return $query->paginate(12);
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedCategory = '';
        $this->priceRange = '';
        $this->sortBy = 'newest';
        $this->onlyInStock = false;
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.home.umkn-profile', [
            'umkn' => $this->umkn,
            'categories' => $this->categories,
            'totalSold' => $this->totalSold,
            'averageRating' => $this->averageRating,
            'products' => $this->products,
        ]);
    }
}
