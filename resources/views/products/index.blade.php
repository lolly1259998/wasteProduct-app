<x-layouts.app :title="'Manage Products'">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 text-center">Manage Products</h1>
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            <div class="text-center mb-6">
                <a href="{{ route('products.create') }}" class="inline-block px-4 py-2 bg-green-400 hover:bg-green-500 text-white font-semibold rounded-md transition duration-150 ease-in-out" style="background-color: #34D399;">Add</a>
            </div>
            <div class="max-w-4xl mx-auto bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-md">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-zinc-700">
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">ID</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Name</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Price</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Stock</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Category</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Recycling Process</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Available</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
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
                            @foreach($products as $product)
                                <tr class="border-b dark:border-zinc-600">
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $product->id }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $product->name }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">${{ $product->price }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $product->stock_quantity }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $wasteCategories[$product->waste_category_id] ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $recyclingProcesses[$product->recycling_process_id] ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $product->is_available ? 'Yes' : 'No' }}</td>
                                    <td class="px-4 py-2 flex space-x-2">
                                        <a href="{{ route('products.show', $product) }}" class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded-md transition duration-150 ease-in-out" style="background-color: #FBBF24;">View</a>
                                        <a href="{{ route('products.edit', $product) }}" class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded-md transition duration-150 ease-in-out" style="background-color: #FBBF24;">Edit</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-400 hover:bg-red-500 text-white font-semibold rounded-md transition duration-150 ease-in-out" style="background-color: #F87171;" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>