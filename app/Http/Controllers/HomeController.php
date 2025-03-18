<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $latestProducts = Product::with('category')
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::all();

        return view('home', compact('latestProducts', 'categories'));
    }
}