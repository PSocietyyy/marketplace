<?php

namespace App\Livewire\Home\Umkn\Product;


use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Layout("layouts.umkn")]
#[Title("Manajemen product")]
class ProductForm extends Component
{
    use WithFileUploads;

    public $edit_id, $is_edit_mode = false;

    public $product_name = '';
    public $description = '';
    public $price = '';
    public $stock = '';
    public $image;
    public $currentImage;
    public $category_id = '';

    public $categories = [];

    public $canManageProduct = false;

    protected $rules = [
        'product_name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|max:2048', // max 2MB
        'category_id' => 'required|exists:categories,id',
    ];

    public function mount($id=null)
    {
        $this->categories = Category::all();
        if($id)
        {
            $this->edit_id = $id;
            $this->getDataById();
            $this->is_edit_mode = true;
        }
        $this->canManageProduct = Auth::user()->umkn->status === "approved";
        $this->isCanManageProduct();
    }

    protected function isCanManageProduct()
    {
        if(!$this->canManageProduct){
            $this->dispatch("alert", message: "UMKN anda belum aktif", type: "warning");
            return redirect()->route('home.umkn.product.index');
        }
    }

    public function getDataById()
    {
        $product = Product::where("id", $this->edit_id)->first();
        if(!$product) 
        {
            $this->dispatch("alert", message: "Product tidak ditemukan", type: "error");
        }

        if($product->umkn->user->id !== Auth::id())
        {
            $this->dispatch("alert", message: "Anda bukan pemilik product ini", type: "warning");
            return redirect()->route('home.umkn.product.index');
        }

        $this->product_name = $product->product_name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->currentImage = $product->image;
        $this->category_id = $product->category_id;
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
        // Upload image
        $imagePath = $this->image->store('products', 'public');

        Product::create([
            'umkn_id' => Auth::user()->umkn_id,
            'product_name' => $this->product_name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $imagePath,
            'category_id' => $this->category_id,
        ]);

        session()->flash('message', 'Produk berhasil ditambahkan!');
        return redirect()->route('home.umkn.product.index');
    }

    protected function updateProduct()
    {
        $product = Product::find($this->edit_id);

        if (!$product) {
            $this->dispatch("alert", message: "Produk tidak ditemukan", type: "error");
            return;
        }

        // Pastikan user pemilik
        if ($product->umkn->user->id !== Auth::id()) {
            $this->dispatch("alert", message: "Anda bukan pemilik produk ini", type: "warning");
            return;
        }

        $imagePath = $this->currentImage;

        if ($this->image) { // ini pasti UploadedFile
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $this->image->store('products', 'public');
        }

        $product->update([
            'product_name' => $this->product_name,
            'description'  => $this->description,
            'price'        => $this->price,
            'stock'        => $this->stock,
            'category_id'  => $this->category_id,
            'image'        => $imagePath,
        ]);

        session()->flash('message', 'Produk berhasil diperbarui!');
        return redirect()->route('home.umkn.product.index');
    }


    public function render()
    {
        return view('livewire.home.umkn.product.product-form');
    }
}
