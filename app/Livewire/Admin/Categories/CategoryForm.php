<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Layout("layouts.admin")]
#[Title("Formulir Kategori")]
class CategoryForm extends Component
{

    public $edit_id, $is_edit_mode = false;

    public $name = '';
    
    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount($id=null)
    {
        if($id)
        {
            $this->edit_id = $id;
            $this->getDataById();
            $this->is_edit_mode = true;
        }
    }

    public function getDataById()
    {
        $category = Category::where("id", $this->edit_id)->first();
        if(!$category) 
        {
            $this->dispatch("alert", message: "Product tidak ditemukan", type: "error");
        }


        $this->name = $category->name;
    }

    public function save()
    {
        $this->validate();

        if ($this->is_edit_mode) {
            $this->updateProduct();
        } else {
            $this->storeProduct();
        }
    }

    protected function storeProduct()
    {
     
        Category::create([
            "name" => $this->name
        ]);
        return redirect()->route('admin.categories.index');
    }

    protected function updateCategory()
    {
        $category = Category::find($this->edit_id);

        if (!$category) {
            $this->dispatch("alert", message: "Category tidak ditemukan", type: "error");
            return;
        }

        $category->update([
            "name" => $this->name
        ]);

        session()->flash('message', 'Produk berhasil diperbarui!');
        return redirect()->route('admin.categories.index');
    }

    public function render()
    {
        return view('livewire.admin.categories.category-form');
    }
}
