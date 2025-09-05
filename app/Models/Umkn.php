<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkn extends Model
{
    protected $fillable = [
        "umkn_name",
        "description",
        "address",
        "number_phone",
        "logo",
        "status"
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
