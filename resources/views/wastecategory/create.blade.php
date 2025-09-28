@extends('components.layouts.app')

<div class="container mx-auto px-4 py-6">
    <div class="max-w-md mx-auto bg-white dark:bg-zinc-800 rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Add New Category</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('waste_categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-500 rounded-md shadow-sm focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:border-teal-400 dark:focus:border-teal-600 dark:bg-zinc-700 dark:text-gray-200" required>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 dark:border-gray-500 rounded-md shadow-sm focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:border-teal-400 dark:focus:border-teal-600 dark:bg-zinc-700 dark:text-gray-200" rows="3" required>{{ old('description') }}</textarea>
            </div>
            <div>
                <label for="recycling_instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recycling Instructions</label>
                <textarea name="recycling_instructions" id="recycling_instructions" class="mt-1 block w-full border-gray-300 dark:border-gray-500 rounded-md shadow-sm focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:border-teal-400 dark:focus:border-teal-600 dark:bg-zinc-700 dark:text-gray-200" rows="3" required>{{ old('recycling_instructions') }}</textarea>
            </div>
            <button type="submit" class="w-full bg-teal-500 dark:bg-teal-700 text-white py-2 px-4 rounded-md hover:bg-teal-600 dark:hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:ring-offset-2 transition duration-150 ease-in-out">
                Save
            </button>
        </form>
    </div>
</div>