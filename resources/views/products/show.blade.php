@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="bg-secondary-light py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-accent hover:text-accent-light">Home</a></li>
                <li><span class="text-gray-500">/</span></li>
                <li><a href="{{ route('products.index') }}" class="text-accent hover:text-accent-light">Products</a></li>
                <li><span class="text-gray-500">/</span></li>
                <li class="text-gray-600">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Product Details -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Left Column - Product Info -->
                <div class="space-y-6">
                    <h1 class="text-3xl font-playfair font-bold text-primary-dark">{{ $product->name }}</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-accent">${{ number_format($product->price, 2) }}</span>
                        <span class="text-sm text-gray-600">Category: 
                            <a href="{{ route('categories.show', $product->category) }}" 
                               class="text-accent hover:text-accent-light">
                                {{ $product->category->name }}
                            </a>
                        </span>
                    </div>
                    <div class="prose max-w-none text-gray-600">
                        {{ $product->description }}
                    </div>

                    @auth
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex items-center space-x-4">
                                <label for="quantity" class="text-gray-700">Quantity:</label>
                                <input type="number" 
                                       name="quantity" 
                                       id="quantity" 
                                       value="1" 
                                       min="1" 
                                       class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-accent focus:border-accent">
                            </div>
                            <button type="submit" 
                                    class="w-full bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-md transition">
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <div class="bg-secondary-light p-4 rounded-md">
                            <p class="text-primary-dark">
                                Please <a href="{{ route('login') }}" class="text-accent hover:text-accent-light">login</a>
                                to add items to your cart.
                            </p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-playfair font-bold text-primary-dark mb-6">Related Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                            <div class="p-4">
                                <h3 class="font-semibold text-primary-dark mb-2">{{ $relatedProduct->name }}</h3>
                                <p class="text-accent font-bold mb-2">${{ number_format($relatedProduct->price, 2) }}</p>
                                <a href="{{ route('products.show', $relatedProduct) }}" 
                                   class="block text-center bg-secondary hover:bg-secondary-dark text-primary-dark px-4 py-2 rounded-md transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection