@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="bg-secondary-light py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-accent hover:text-accent-light">Home</a></li>
                <li><span class="text-gray-500">/</span></li>
                <li><a href="{{ route('categories.index') }}" class="text-accent hover:text-accent-light">Categories</a></li>
                <li><span class="text-gray-500">/</span></li>
                <li class="text-gray-600">{{ $category->name }}</li>
            </ol>
        </nav>

        <h1 class="text-3xl font-playfair font-bold text-primary-dark mb-8">{{ $category->name }}</h1>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($category->products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="p-4">
                        <h3 class="font-semibold text-primary-dark mb-2">{{ $product->name }}</h3>
                        <p class="text-accent font-bold mb-2">${{ number_format($product->price, 2) }}</p>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->description, 100) }}</p>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('products.show', $product) }}" 
                               class="flex-1 text-center bg-secondary hover:bg-secondary-dark text-primary-dark px-4 py-2 rounded-md transition">
                                View Details
                            </a>
                            
                            @auth
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            class="w-full bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-md transition">
                                        Add to Cart
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-600">No products found in this category.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection