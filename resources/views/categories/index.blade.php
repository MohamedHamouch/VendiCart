@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="bg-secondary-light py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-playfair font-bold text-primary-dark mb-8">Product Categories</h1>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($categories as $category)
                <a href="{{ route('categories.show', $category) }}" 
                   class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-primary-dark mb-2">{{ $category->name }}</h2>
                        <p class="text-sm text-gray-600">
                            {{ $category->products_count ?? 0 }} Products
                        </p>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-600">No categories found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection