<x-layouts.app :title="'Create Donation'">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 text-center">Create Donation</h1>
            <form method="POST" action="{{ route('donations.store') }}" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-md">
                @csrf
                <div class="mb-4">
                    <label for="user_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">User ID</label>
                    <input type="number" name="user_id" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                </div>
                <div class="mb-4">
                    <label for="waste_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Waste Type</label>
                    <select name="waste_id" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                        @foreach($wastes as $id => $waste)
                            <option value="{{ $id }}">{{ $waste['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="item_name" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Item Name</label>
                    <input type="text" name="item_name" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                </div>
                <div class="mb-4">
                    <label for="condition" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Condition</label>
                    <select name="condition" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                        <option value="new">New</option>
                        <option value="used">Used</option>
                        <option value="damaged">Damaged</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Description</label>
                    <textarea name="description" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100"></textarea>
                </div>
                <div class="mb-4">
                    <label for="images" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Images</label>
                    <input type="file" name="images[]" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" multiple>
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="pickup_required" class="h-4 w-4 text-green-400 focus:ring-green-500 border-gray-300 dark:border-zinc-600 rounded" id="pickup_required">
                    <label for="pickup_required" class="ml-2 text-gray-700 dark:text-gray-300">Pickup Required</label>
                </div>
                <div class="mb-4">
                    <label for="pickup_address" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Pickup Address</label>
                    <input type="text" name="pickup_address" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100">
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-green-400 text-white font-semibold py-2 px-4 rounded-md hover:bg-green-500 transition duration-150 ease-in-out" style="background-color: #34D399; color: white; padding: 8px 16px; border-radius: 4px;">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>