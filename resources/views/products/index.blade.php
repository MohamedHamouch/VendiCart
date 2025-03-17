@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="bg-secondary-light py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-playfair font-bold text-primary-dark mb-8">Our Products</h1>

        <!-- Filters and Search (if needed) -->
        <div class="mb-8">
            <form action="{{ route('products.index') }}" method="GET" class="flex gap-4">
                <input type="text" 
                       name="search" 
                       placeholder="Search products..." 
                       value="{{ request('search') }}"
                       class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-accent focus:border-accent">
                       
                <button type="submit" 
                        class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-md transition">
                    Search
                </button>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="p-4">
                        <h3 class="font-semibold text-primary-dark mb-2">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $product->category->name }}</p>
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
                    <p class="text-gray-600">No products found.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection