<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Travel Insurance</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow w-full max-w-sm text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Travel Insurance</h1>
        <p class="text-gray-500 mb-6">Get an instant quote for your trip.</p>
        <div class="flex gap-3 justify-center">
            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">Login</a>
            <a href="{{ route('register') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm rounded hover:bg-gray-50">Register</a>
        </div>
    </div>
</body>
</html>
