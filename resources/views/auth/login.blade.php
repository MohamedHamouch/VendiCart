<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VendiCart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-blue-900">
    <header class="bg-blue-300 p-4 text-center">
        <h1 class="text-4xl font-bold">Login</h1>
    </header>
    <main class="p-4">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-lg">Email</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-lg">Password</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-blue-500" required>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">Login</button>
            </div>
        </form>
    </main>
</body>
</html>