<x-layouts.app :title="'Edit Product #'.$product->id">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 text-center">Edit Product #{{ $product->id }}</h1>
            <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-md">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name" value="{{ $product->name }}" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Description</label>
                    <textarea name="description" id="description" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100">{{ $product->description }}</textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Price</label>
                    <input type="number" name="price" id="price" step="0.01" min="0" value="{{ $product->price }}" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="stock_quantity" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" min="0" value="{{ $product->stock_quantity }}" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                    @error('stock_quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="waste_category_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Waste Category</label>
                    <select name="waste_category_id" id="waste_category_id" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                        <option value="1" {{ $product->waste_category_id == 1 ? 'selected' : '' }}>Plastic</option>
                        <option value="2" {{ $product->waste_category_id == 2 ? 'selected' : '' }}>Paper</option>
                        <option value="3" {{ $product->waste_category_id == 3 ? 'selected' : '' }}>Glass</option>
                        <option value="4" {{ $product->waste_category_id == 4 ? 'selected' : '' }}>Metal</option>
                    </select>
                    @error('waste_category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="recycling_process_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Recycling Process</label>
                    <select name="recycling_process_id" id="recycling_process_id" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                        <option value="1" {{ $product->recycling_process_id == 1 ? 'selected' : '' }}>Mechanical Recycling</option>
                        <option value="2" {{ $product->recycling_process_id == 2 ? 'selected' : '' }}>Chemical Recycling</option>
                        <option value="3" {{ $product->recycling_process_id == 3 ? 'selected' : '' }}>Composting</option>
                        <option value="4" {{ $product->recycling_process_id == 4 ? 'selected' : '' }}>Incineration</option>
                    </select>
                    @error('recycling_process_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="image_path" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Image</label>
                    <input type="file" name="image_path" id="image_path" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100">
                    @if($product->image_path)
                        <p class="mt-2 text-gray-700 dark:text-gray-300">Current Image:</p>
                        <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-md">
                    @endif
                    @error('image_path') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="specifications" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Specifications (JSON)</label>
                    <textarea name="specifications" id="specifications" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" placeholder='{"material": "plastic", "weight": "500g"}'>{{ json_encode($product->specifications, JSON_PRETTY_PRINT) }}</textarea>
                    @error('specifications') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="is_available" id="is_available" class="h-4 w-4 text-green-400 focus:ring-green-500 border-gray-300 dark:border-zinc-600 rounded" {{ $product->is_available ? 'checked' : '' }}>
                    <label for="is_available" class="ml-2 text-gray-700 dark:text-gray-300">Is Available</label>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-yellow-400 text-white font-semibold py-2 px-4 rounded-md hover:bg-yellow-500 transition duration-150 ease-in-out" style="background-color: #FBBF24;">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>