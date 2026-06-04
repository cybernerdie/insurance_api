<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Travel Insurance</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10 px-4">
    <div class="bg-white p-8 rounded shadow w-full max-w-md">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Login</h1>

        <form id="login-form" novalidate class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                <span class="field-error text-xs text-red-600 mt-1 block" id="email-error"></span>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                <span class="field-error text-xs text-red-600 mt-1 block" id="password-error"></span>
            </div>

            <div id="form-error" class="text-sm text-red-600"></div>

            <button type="submit" class="w-full py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                Login
            </button>
        </form>

        <p class="text-sm text-gray-500 text-center mt-5">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
        </p>
    </div>

    @vite(['resources/js/auth.js'])
</body>
</html>
