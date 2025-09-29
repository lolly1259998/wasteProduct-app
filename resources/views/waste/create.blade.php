@extends('components.layouts.app')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-md mx-auto bg-white dark:bg-zinc-800 rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Add New Waste</h1>

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

        <form action="{{ route('wastes.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                <input type="text" name="type" id="type" value="{{ old('type') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-500 rounded-md shadow-sm focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:border-teal-400 dark:focus:border-teal-600 dark:bg-zinc-700 dark:text-gray-200" required>
            </div>
            <div>
                <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Weight (kg)</label>
                <input type="number" step="0.01" name="weight" id="weight" value="{{ old('weight') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-500 rounded-md shadow-sm focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:border-teal-400 dark:focus:border-teal-600 dark:bg-zinc-700 dark:text-gray-200" required>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 dark:border-gray-500 rounded-md shadow-sm focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:border-teal-400 dark:focus:border-teal-600 dark:bg-zinc-700 dark:text-gray-200" required>
                    <option value="recyclable" {{ old('status') == 'recyclable' ? 'selected' : '' }}>Recyclable</option>
                    <option value="reusable" {{ old('status') == 'reusable' ? 'selected' : '' }}>Reusable</option>
                </select>
            </div>
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">User</label>
                <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 dark:border-gray-500 rounded-md shadow-sm focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:border-teal-400 dark:focus:border-teal-600 dark:bg-zinc-700 dark:text-gray-200" required>
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="waste_category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waste Category</label>
                <select name="waste_category_id" id="waste_category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-500 rounded-md shadow-sm focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:border-teal-400 dark:focus:border-teal-600 dark:bg-zinc-700 dark:text-gray-200" required>
                    @foreach(\App\Models\WasteCategory::all() as $category)
                        <option value="{{ $category->id }}" {{ old('waste_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="collection_point_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Collection Point</label>
                <select name="collection_point_id" id="collection_point_id" class="mt-1 block w-full border-gray-300 dark:border-gray-500 rounded-md shadow-sm focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:border-teal-400 dark:focus:border-teal-600 dark:bg-zinc-700 dark:text-gray-200" required>
                    @php
                        // Assuming a static collection point ID (e.g., 1), adjust as needed
                        $staticCollectionPoint = \App\Models\CollectionPoint::find(1);
                        if ($staticCollectionPoint) {
                            echo '<option value="' . $staticCollectionPoint->id . '" ' . (old('collection_point_id') == $staticCollectionPoint->id ? 'selected' : '') . '>' . $staticCollectionPoint->name . '</option>';
                        } else {
                            echo '<option value="" disabled selected>No collection point available</option>';
                        }
                    @endphp
                </select>
            </div>
            <div>
                <label for="image_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image Path</label>
                <input type="text" name="image_path" id="image_path" value="{{ old('image_path') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-500 rounded-md shadow-sm focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:border-teal-400 dark:focus:border-teal-600 dark:bg-zinc-700 dark:text-gray-200">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 dark:border-gray-500 rounded-md shadow-sm focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:border-teal-400 dark:focus:border-teal-600 dark:bg-zinc-700 dark:text-gray-200" rows="3" required>{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="w-full bg-teal-500 dark:bg-teal-700 text-white py-2 px-4 rounded-md hover:bg-teal-600 dark:hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-400 dark:focus:ring-teal-600 focus:ring-offset-2 transition duration-150 ease-in-out">
                Save
            </button>
        </form>
    </div>
</div>