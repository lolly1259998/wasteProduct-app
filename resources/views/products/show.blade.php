<x-layouts.app :title="'Product #'.$product->id">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 text-center">Product #{{ $product->id }}</h1>
            <div class="max-w-lg mx-auto bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-md">
                <div class="mb-4 space-y-2">
                    @php
                        $wasteCategories = [
                            1 => 'Plastic',
                            2 => 'Paper',
                            3 => 'Glass',
                            4 => 'Metal',
                        ];
                        $recyclingProcesses = [
                            1 => 'Mechanical Recycling',
                            2 => 'Chemical Recycling',
                            3 => 'Composting',
                            4 => 'Incineration',
                        ];
                    @endphp
                    <p><strong class="text-gray-700 dark:text-gray-300">Name:</strong> <span class="text-gray-900 dark:text-gray-100">{{ $product->name }}</span></p>
                    <p><strong class="text-gray-700 dark:text-gray-300">Description:</strong> <span class="text-gray-900 dark:text-gray-100">{{ $product->description ?? 'N/A' }}</span></p>
                    <p><strong class="text-gray-700 dark:text-gray-300">Price:</strong> <span class="text-gray-900 dark:text-gray-100">${{ $product->price }}</span></p>
                    <p><strong class="text-gray-700 dark:text-gray-300">Stock Quantity:</strong> <span class="text-gray-900 dark:text-gray-100">{{ $product->stock_quantity }}</span></p>
                    <p><strong class="text-gray-700 dark:text-gray-300">Waste Category:</strong> <span class="text-gray-900 dark:text-gray-100">{{ $wasteCategories[$product->waste_category_id] ?? 'N/A' }}</span></p>
                    <p><strong class="text-gray-700 dark:text-gray-300">Recycling Process:</strong> <span class="text-gray-900 dark:text-gray-100">{{ $recyclingProcesses[$product->recycling_process_id] ?? 'N/A' }}</span></p>
                    <p><strong class="text-gray-700 dark:text-gray-300">Available:</strong> <span class="text-gray-900 dark:text-gray-100">{{ $product->is_available ? 'Yes' : 'No' }}</span></p>
                    <p><strong class="text-gray-700 dark:text-gray-300">Specifications:</strong> <span class="text-gray-900 dark:text-gray-100">{{ json_encode($product->specifications, JSON_PRETTY_PRINT) ?? 'N/A' }}</span></p>
                    @if($product->image_path)
                        <p><strong class="text-gray-700 dark:text-gray-300">Image:</strong></p>
                        <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-md">
                    @endif
                </div>
                <div class="text-center flex justify-center space-x-4">
                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white font-semibold rounded-md transition duration-150 ease-in-out" style="background-color: #9CA3AF;">Back</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-400 hover:bg-red-500 text-white font-semibold rounded-md transition duration-150 ease-in-out" style="background-color: #F87171;" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>