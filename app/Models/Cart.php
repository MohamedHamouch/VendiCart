<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'total'];

    // Cart belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cart has many items
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Cart has many products through cart_items
    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
