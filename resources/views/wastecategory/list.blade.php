@extends('components.layouts.app')

<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 text-center">Waste Categories</h1>
        
        <!-- Single Add Button Below Title -->
        <div class="text-center mb-6">
            <a href="{{ route('waste_categories.create') }}" class="inline-block bg-green-400 p-2 rounded-full hover:bg-green-500 transition duration-150 ease-in-out debug">
                <x-heroicon-o-plus class="h-5 w-5 text-white" />
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 rounded text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <div class="bg-white dark:bg-zinc-800 shadow-md rounded-lg p-4 hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                    <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">{{ $category->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">{{ $category->description }}</p>
                    <p class="text-gray-500 dark:text-gray-500 text-sm mt-1">{{ $category->recycling_instructions }}</p>
                    <div class="mt-4 flex space-x-2">
                        <a href="{{ route('waste_categories.edit', $category->id) }}" class="bg-blue-400 p-2 rounded-full hover:bg-blue-500 transition duration-150 ease-in-out debug">
                            <x-heroicon-o-pencil class="h-5 w-5 text-white" />
                        </a>
                        <form action="{{ route('waste_categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-400 p-2 rounded-full hover:bg-red-500 transition duration-150 ease-in-out debug" onclick="return confirm('Are you sure you want to delete this category?')">
                                <x-heroicon-o-trash class="h-5 w-5 text-white" />
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .debug {
        outline: 1px solid yellow; /* Visual debug border */
    }
</style>