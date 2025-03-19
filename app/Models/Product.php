<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'category_id'
    ];

    // Product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product can be in many orders through order_items
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items');
    }

    // Product can be in many carts through cart_items
    
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }


    // Product can have many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
