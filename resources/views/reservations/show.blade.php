<x-layouts.app :title="'Reservation #'.$reservation->id">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 text-center">Reservation #{{ $reservation->id }}</h1>
            <div class="max-w-lg mx-auto bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-md">
                <div class="mb-4 space-y-2">
                    <p><strong class="text-gray-700 dark:text-gray-300">User ID:</strong> <span class="text-gray-900 dark:text-gray-100">{{ $reservation->user_id }}</span></p>
                    <p><strong class="text-gray-700 dark:text-gray-300">Product:</strong> <span class="text-gray-900 dark:text-gray-100">{{ $reservation->product->name ?? 'N/A' }}</span></p>
                    <p><strong class="text-gray-700 dark:text-gray-300">Quantity:</strong> <span class="text-gray-900 dark:text-gray-100">{{ $reservation->quantity }}</span></p>
                    <p><strong class="text-gray-700 dark:text-gray-300">Reserved Until:</strong> <span class="text-gray-900 dark:text-gray-100">{{ $reservation->reserved_until->format('Y-m-d') }}</span></p>
                    <p><strong class="text-gray-700 dark:text-gray-300">Status:</strong> <span class="text-gray-900 dark:text-gray-100">{{ $reservation->status->value }}</span></p>
                </div>
                <div class="text-center flex justify-center space-x-4">
                    <a href="{{ route('reservations.index') }}" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white font-semibold rounded-md transition duration-150 ease-in-out" style="background-color: #9CA3AF;">Back</a>
                    <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-400 hover:bg-red-500 text-white font-semibold rounded-md transition duration-150 ease-in-out" style="background-color: #F87171;" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>