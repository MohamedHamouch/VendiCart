<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->paginate(12);
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        $reviews = $product->reviews()->with('user')->latest()->get();
        $averageRating = $reviews->avg('rating');

        return view('products.show', compact('product', 'relatedProducts', 'reviews', 'averageRating'));
    }
}