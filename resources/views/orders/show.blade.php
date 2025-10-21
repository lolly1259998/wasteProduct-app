<x-layouts.app :title="'Order #'.$order->id">
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-md mx-auto bg-white dark:bg-zinc-800 rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Order #{{ $order->id }}</h1>

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                <p class="text-gray-600 dark:text-gray-400"><strong>User:</strong> {{ $order->user->name ?? 'Unknown' }}</p>
                <p class="text-gray-600 dark:text-gray-400"><strong>Product:</strong> {{ $order->product->name ?? 'N/A' }}</p>
                <p class="text-gray-600 dark:text-gray-400"><strong>Quantity:</strong> {{ $order->quantity }}</p>
                <p class="text-gray-600 dark:text-gray-400"><strong>Total:</strong> ${{ $order->total_amount }}</p>
                <p class="text-gray-600 dark:text-gray-400"><strong>Status:</strong> {{ $order->status }}</p>
                <p class="text-gray-600 dark:text-gray-400"><strong>Order Date:</strong> {{ $order->order_date->format('Y-m-d') }}</p>
                <p class="text-gray-600 dark:text-gray-400"><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                <p class="text-gray-600 dark:text-gray-400"><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                @if($order->tracking_number)
                    <p class="text-gray-600 dark:text-gray-400"><strong>Tracking Number:</strong> {{ $order->tracking_number }}</p>
                @endif
                <div class="mt-6 flex space-x-2">
                    <a href="{{ route('orders.edit', $order) }}" class="inline-block bg-yellow-400 p-2 rounded-full hover:bg-yellow-500 transition duration-150 ease-in-out" style="background-color: #FBBF24;">
                        <x-heroicon-o-pencil class="h-5 w-5 text-white" />
                    </a>
                    <a href="{{ route('orders.index') }}" class="inline-block bg-gray-400 p-2 rounded-full hover:bg-gray-500 transition duration-150 ease-in-out" style="background-color: #9CA3AF;">
                        <x-heroicon-o-arrow-left class="h-5 w-5 text-white" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>