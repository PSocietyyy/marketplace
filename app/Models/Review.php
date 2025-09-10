<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'parent_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function replies()
    {
        return $this->hasMany(Review::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Review::class, 'parent_id');
    }

    /**
     * Check if a user has purchased a specific product
     */
    public static function hasUserPurchasedProduct($userId, $productId)
    {
        return OrderItem::whereHas('order', function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('status', 'completed');
        })->where('product_id', $productId)->exists();
    }

    /**
     * Check if a user has already reviewed a product
     */
    public static function hasUserReviewedProduct($userId, $productId)
    {
        return self::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->whereNull('parent_id') // Only main reviews, not replies
                   ->exists();
    }

    /**
     * Get average rating for a product
     */
    public static function getAverageRating($productId)
    {
        return self::where('product_id', $productId)
                   ->whereNull('parent_id')
                   ->avg('rating') ?: 0;
    }

    /**
     * Get total reviews count for a product
     */
    public static function getTotalReviews($productId)
    {
        return self::where('product_id', $productId)
                   ->whereNull('parent_id')
                   ->count();
    }

    /**
     * Scope for main reviews (not replies)
     */
    public function scopeMainReviews($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for replies only
     */
    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }
}