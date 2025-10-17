<x-layouts.app :title="'Create Order'">
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-md mx-auto bg-white dark:bg-zinc-800 rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Create Order</h1>

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

            <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">User</label>
                    <select name="user_id" id="user_id" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-400 focus:border-green-400" required>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product</label>
                    <select name="product_id" id="product_id" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-400 focus:border-green-400" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-400 focus:border-green-400" required>
                    @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Amount</label>
                    <input type="number" name="total_amount" id="total_amount" value="{{ old('total_amount') }}" step="0.01" min="0" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-400 focus:border-green-400" required>
                    @error('total_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-400 focus:border-green-400" required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ old('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="order_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order Date</label>
                    <input type="date" name="order_date" id="order_date" value="{{ old('order_date', now()->format('Y-m-d')) }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-400 focus:border-green-400" required>
                    @error('order_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shipping Address</label>
                    <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address') }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-400 focus:border-green-400" required>
                    @error('shipping_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-400 focus:border-green-400" required>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                    @error('payment_method') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="tracking_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tracking Number (Optional)</label>
                    <input type="text" name="tracking_number" id="tracking_number" value="{{ old('tracking_number') }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-zinc-600 rounded-md bg-gray-50 dark:bg-zinc-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-400 focus:border-green-400">
                    @error('tracking_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="w-full bg-green-400 text-white font-semibold py-2 px-4 rounded-md hover:bg-green-500 transition duration-150 ease-in-out" style="background-color: #34D399;">Create</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>