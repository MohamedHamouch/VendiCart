<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - VendiCart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-blue-900">
    <header class="bg-blue-300 p-4 text-center">
        <h1 class="text-4xl font-bold">Register</h1>
    </header>
    <main class="p-4">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-lg">Name</label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-lg">Email</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-lg">Password</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-lg">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-2 border border-blue-500" required>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">Register</button>
            </div>
        </form>
    </main>
</body>
</html>