<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VendiCart') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Source+Sans+Pro:wght@300;400;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-secondary-light min-h-screen">
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        @include('layouts.navigation')

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-success text-white px-6 py-4 border-0 rounded relative mb-4 mx-4 mt-4">
                <span class="inline-block align-middle mr-8">
                    {{ session('success') }}
                </span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-error text-white px-6 py-4 border-0 rounded relative mb-4 mx-4 mt-4">
                <span class="inline-block align-middle mr-8">
                    {{ session('error') }}
                </span>
            </div>
        @endif

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-8">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.footer')
    </div>
</body>

</html>