<?php

namespace App\Livewire\Home\Umkn\Product;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Layout("layouts.umkn")]
#[Title("Manajemen product")]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;

    public $showDeleteModal = false;
    public $productToDelete = null;

    public $categories = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function confirmDelete($productId)
    {
        $this->productToDelete = Product::find($productId);
        $this->showDeleteModal = true;
    }

    public function deleteProduct()
    {
        if ($this->productToDelete) {
            // Delete image if exists
            if ($this->productToDelete->image) {
                Storage::disk('public')->delete($this->productToDelete->image);
            }

            $this->productToDelete->delete();
            
            session()->flash('message', 'Produk berhasil dihapus!');
            $this->showDeleteModal = false;
            $this->productToDelete = null;
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->productToDelete = null;
    }

    public function getProducts()
    {
        $query = Product::with(['category'])
            ->where('umkn_id', Auth::user()->umkn_id);

        if ($this->search) {
            $query->where('product_name', 'like', '%' . $this->search . '%');
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)
                    ->paginate($this->perPage);
    }


    public function addProduct()
    {
        return redirect()->route('home.umkn.product.form.create');
    }

    public function editProduct($id)
    {
        return redirect()->route('home.umkn.product.form.edit', $id);
    }

    public function productDetail($id)
    {
        return redirect()->route('home.umkn.product.detail', $id);
    }

    public function clearFilters()
    {
        $this->reset(['search', 'categoryFilter']);
        $this->resetPage();
    }


    public function render()
    {
        $products = $this->getProducts();
        
        return view('livewire.home.umkn.product.index', [
            'products' => $products,
        ]);
    }
}