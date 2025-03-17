<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'is_approved'
    ];

    // Review belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Review belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
