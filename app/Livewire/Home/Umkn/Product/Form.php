<?php

namespace App\Livewire\Home\Umkn\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use App\Models\Umkn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Form extends Component
{
    use WithFileUploads;

    public Product $product;
    public $isEdit = false;
    
    // Form fields
    public $product_name;
    public $description;
    public $price;
    public $stock;
    public $category_id;
    public $image;
    public $existingImage;

    // Data
    public $categories = [];
    public $umkn;

    public function mount($id = null)
    {
        $this->umkn = Auth::user()->umkn_id;
        $this->categories = Category::all();

        if ($id) {
            $this->isEdit = true;
            $this->product = Product::findOrFail($id);
            $this->product_name = $this->product->product_name;
            $this->description = $this->product->description;
            $this->price = $this->product->price;
            $this->stock = $this->product->stock;
            $this->category_id = $this->product->category_id;
            $this->existingImage = $this->product->image;
        } else {
            $this->product = new Product();
        }
    }

    protected $rules = [
        'product_name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:2048'
    ];

    protected $messages = [
        'product_name.required' => 'Nama produk harus diisi.',
        'description.required' => 'Deskripsi produk harus diisi.',
        'price.required' => 'Harga produk harus diisi.',
        'price.numeric' => 'Harga harus berupa angka.',
        'price.min' => 'Harga tidak boleh kurang dari 0.',
        'stock.required' => 'Stok produk harus diisi.',
        'stock.integer' => 'Stok harus berupa angka bulat.',
        'stock.min' => 'Stok tidak boleh kurang dari 0.',
        'category_id.required' => 'Kategori harus dipilih.',
        'category_id.exists' => 'Kategori yang dipilih tidak valid.',
        'image.image' => 'File harus berupa gambar.',
        'image.max' => 'Ukuran gambar maksimal 2MB.'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'umkn_id' => $this->umkn->id,
                'product_name' => $this->product_name,
                'description' => $this->description,
                'price' => $this->price,
                'stock' => $this->stock,
                'category_id' => $this->category_id,
            ];

            if ($this->image) {
                // Delete old image if editing
                if ($this->isEdit && $this->existingImage) {
                    Storage::disk('public')->delete($this->existingImage);
                }

                $imagePath = $this->image->store('products', 'public');
                $data['image'] = $imagePath;
            }

            if ($this->isEdit) {
                $this->product->update($data);
                session()->flash('message', 'Produk berhasil diperbarui!');
            } else {
                Product::create($data);
                session()->flash('message', 'Produk berhasil ditambahkan!');
            }

            return redirect()->route('home.umkn.product.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.home.umkn.product.form');
    }
}