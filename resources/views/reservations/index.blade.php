<x-layouts.app :title="'Manage Reservations'">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 text-center">Manage Reservations</h1>
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            <div class="text-center mb-6">
                <a href="{{ route('reservations.create') }}" class="inline-block px-4 py-2 bg-green-400 hover:bg-green-500 text-white font-semibold rounded-md transition duration-150 ease-in-out" style="background-color: #34D399;">Add</a>
            </div>
            <div class="max-w-4xl mx-auto bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-md">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-zinc-700">
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">ID</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">User ID</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Product</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Quantity</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Reserved Until</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Status</th>
                                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr class="border-b dark:border-zinc-600">
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $reservation->id }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $reservation->user_id }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $reservation->product->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $reservation->quantity }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $reservation->reserved_until->format('Y-m-d') }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $reservation->status->value }}</td>
                                    <td class="px-4 py-2 flex space-x-2">
                                        <a href="{{ route('reservations.show', $reservation) }}" class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded-md transition duration-150 ease-in-out" style="background-color: #FBBF24;">View</a>
                                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="inline">
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