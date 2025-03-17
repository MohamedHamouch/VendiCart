@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-secondary-light py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
        <div>
            <h2 class="mt-6 text-center text-3xl font-playfair font-bold text-primary-dark">
                Create an Account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Or
                <a href="{{ route('login') }}" class="font-medium text-accent hover:text-accent-light">
                    sign in to your account
                </a>
            </p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('register.submit') }}" method="POST">
            @csrf

            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input id="name" name="name" type="text" required 
                        class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 
                        placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-accent 
                        focus:border-accent focus:z-10 sm:text-sm @error('name') border-red-500 @enderror"
                        value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input id="email" name="email" type="email" required 
                        class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 
                        placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-accent 
                        focus:border-accent focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required 
                        class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 
                        placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-accent 
                        focus:border-accent focus:z-10 sm:text-sm @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                        class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 
                        placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-accent 
                        focus:border-accent focus:z-10 sm:text-sm">
                </div>
            </div>

            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent 
                    text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark 
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>
@endsection