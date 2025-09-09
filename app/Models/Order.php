<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        "order_code",
        "user_id",
        "total_price",
        "status"
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function($order) {
            if(!$order->order_code) {
                $unqiue_code = (string) Str::uuid();
                $order->order_code = "INV-". $unqiue_code;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
