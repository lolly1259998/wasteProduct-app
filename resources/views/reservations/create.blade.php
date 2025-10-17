<x-layouts.app :title="'Create Reservation'">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 text-center">Create Reservation</h1>
            <form method="POST" action="{{ route('reservations.store') }}" class="max-w-lg mx-auto bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-md">
                @csrf
                <div class="mb-4">
                    <label for="user_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">User ID</label>
                    <input type="number" name="user_id" id="user_id" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                    @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="product_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Product</label>
                    <select name="product_id" id="product_id" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Quantity</label>
                    <input type="number" name="quantity" id="quantity" min="1" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                    @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="reserved_until" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Reserved Until</label>
                    <input type="date" name="reserved_until" id="reserved_until" class="w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100" required>
                    @error('reserved_until') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-green-400 text-white font-semibold py-2 px-4 rounded-md hover:bg-green-500 transition duration-150 ease-in-out" style="background-color: #34D399;">Create</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>