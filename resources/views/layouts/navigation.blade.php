<nav class="bg-primary text-text-light">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-playfair font-bold">
                    VendiCart
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('products.index') }}" class="hover:text-secondary-light transition">Products</a>
                <a href="{{ route('categories.index') }}" class="hover:text-secondary-light transition">Categories</a>
                
                @auth
                    <a href="{{ route('cart.index') }}" class="hover:text-secondary-light transition">
                        Cart <span class="bg-accent rounded-full px-2 py-1 text-xs">
                            {{ Auth::user()->cart?->items_count ?? 0 }}
                        </span>
                    </a>
                @else
                    <a href="{{ route('cart.index') }}" class="hover:text-secondary-light transition">Cart</a>
                @endauth
            </div>

            <!-- Auth Links -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <div class="relative group">
                        <button class="flex items-center hover:text-secondary-light transition">
                            {{ Auth::user()->name }}
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden group-hover:block">
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-text-dark hover:bg-secondary-light">
                                    Dashboard
                                </a>
                            @endif
                            <a href="#" class="block px-4 py-2 text-sm text-text-dark hover:bg-secondary-light">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-text-dark hover:bg-secondary-light">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hover:text-secondary-light transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-accent hover:bg-accent-light text-white px-4 py-2 rounded-md transition">
                        Register
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button class="mobile-menu-button">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>