<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price'
    ];

    // Item belongs to a cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
