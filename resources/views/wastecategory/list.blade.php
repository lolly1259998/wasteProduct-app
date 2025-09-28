@extends('components.layouts.app')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Waste Categories</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($categories as $category)
            <div class="bg-white dark:bg-zinc-700 shadow rounded-lg p-4 hover:shadow-lg transition">
                <h2 class="text-xl font-semibold mb-2">{{ $category->name }}</h2>
                <p class="text-gray-600 dark:text-gray-300">{{ $category->description }}</p>
            </div>
        @endforeach
    </div>
</div>
