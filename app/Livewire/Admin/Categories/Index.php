<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout("layouts.admin")]
#[Title("Manjemen Category")]
class Index extends Component
{
    public $search = '';
    public $perPage = 12;

    public $showDeleteModal = false;
    public $categoryToDelete = null;

    protected $queryString = [
        'search' => ['except' => '']
    ];


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($categoryId)
    {
        $this->categoryToDelete = Category::find($categoryId);
        $this->showDeleteModal = true;
    }

    public function deleteCategory()
    {
        if($this->categoryToDelete) {
            $this->categoryToDelete->delete();
            $this->dispatch("alert", message: "Kategori berhasil dihapus", type: "success");
            $this->showDeleteModal = false;
            $this->categoryToDelete = null;
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->categoryToDelete = null;
    }

    public function getCategories()
    {
        $query = Category::query();

        if ($this->search) {
            $query->where('name', 'like', '%'.$this->search.'%');
        }

        return $query->paginate($this->perPage);
    }

    public function clearFilters()
    {
        $this->reset(['search']);
    }

    public function render()
    {
        $categories = $this->getCategories();
        return view('livewire.admin.categories.index', [
            'categories' => $categories
        ]);
    }
}
