<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-900 text-gray-100">
    <div class="mx-auto max-w-7xl p-6">
        <header class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold">@yield('title')</h1>
            <nav class="space-x-3 text-sm">
                <a class="text-gray-300 hover:text-white" href="{{ route('manage.categories.index') }}">Categories</a>
                <a class="text-gray-300 hover:text-white" href="{{ route('manage.products.index') }}">Products</a>
            </nav>
        </header>
        @if (session('status'))
            <div class="mb-4 rounded-md border border-green-500 bg-green-900/30 px-4 py-2 text-green-300">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>


