<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "umkn_id",
        "product_name",
        "description",
        "price",
        "stock",
        "image",
        "category_id"
    ];

    public function umkn()
    {
        return $this->belongsTo(Umkn::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper mendapatkan path
    public function getUrlImage()
    {
        if(str_starts_with($this->image, "https")) {
            return $this->image;
        }
        return asset('storage/'.$this->image);
    }
}
