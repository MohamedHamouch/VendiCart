@extends('layouts.app')

@section('title', 'Welcome to VendiCart')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-primary-dark text-text-light">
        <div class="container mx-auto px-4 py-24">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div class="space-y-6">
                    <h1 class="font-playfair text-4xl md:text-5xl lg:text-6xl font-bold">
                        Welcome to VendiCart
                    </h1>
                    <p class="text-lg text-secondary-light">
                        Discover our collection of quality products at great prices.
                    </p>
                    <div class="flex space-x-4">
                        <a href="{{ route('products.index') }}" 
                           class="bg-accent hover:bg-accent-light text-white px-6 py-3 rounded-md transition duration-300 inline-block">
                            Browse Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="py-16 bg-secondary-light">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-playfair font-bold text-primary-dark mb-8 text-center">
                Shop by Category
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category) }}" 
                       class="group">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform hover:-translate-y-1 hover:shadow-xl">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-primary-dark group-hover:text-accent transition text-center">
                                    {{ $category->name }}
                                </h3>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Latest Products -->
    <div class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-playfair font-bold text-primary-dark mb-8 text-center">
                Latest Products
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($latestProducts as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                        <div class="p-4">
                            <h3 class="font-semibold text-primary-dark mb-2">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $product->category->name }}</p>
                            <p class="text-accent font-bold mb-2">${{ number_format($product->price, 2) }}</p>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->description, 100) }}</p>
                            
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                        class="w-full bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded transition">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-secondary-light">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-primary-dark text-secondary-light rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-primary-dark mb-2">Easy Shopping</h3>
                    <p class="text-gray-600">Simple and seamless shopping experience</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary-dark text-secondary-light rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-primary-dark mb-2">Fast Delivery</h3>
                    <p class="text-gray-600">Quick delivery to your location</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary-dark text-secondary-light rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-primary-dark mb-2">Secure Payments</h3>
                    <p class="text-gray-600">Safe and secure payment methods</p>
                </div>
            </div>
        </div>
    </div>
@endsection