<x-layouts.app :title="'Donation #'.$donation->id">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 text-center">Donation #{{ $donation->id }}</h1>
            <div class="bg-white dark:bg-zinc-800 shadow-md rounded-lg p-6 max-w-lg mx-auto">
                <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>User:</strong> {{ $donation->user->name ?? 'Unknown' }}</p>
                <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Waste Type:</strong> {{ \App\Http\Controllers\DonationController::getWasteTypeName($donation->waste_id) }}</p>
                <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Item Name:</strong> {{ $donation->item_name }}</p>
                <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Condition:</strong> {{ $donation->condition }}</p>
                <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Status:</strong> {{ $donation->status->value }}</p>
                <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Description:</strong> {{ $donation->description ?? 'N/A' }}</p>
                <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Pickup:</strong> {{ $donation->pickup_required ? 'Yes: ' . $donation->pickup_address : 'No' }}</p>
                @if($donation->images)
                    <p class="text-gray-600 dark:text-gray-400 mb-2"><strong>Images:</strong></p>
                    @foreach($donation->images as $image)
                        <img src="{{ Storage::url($image) }}" alt="Donation Image" class="mt-2 max-w-[200px] rounded">
                    @endforeach
                @endif
                <div class="mt-4 flex justify-center space-x-2">
                    <a href="{{ route('donations.index') }}" class="bg-gray-400 text-white font-semibold py-2 px-4 rounded-md hover:bg-gray-500 transition duration-150 ease-in-out" style="background-color: #9CA3AF; color: white; padding: 8px 16px; border-radius: 4px;">
                        Back
                    </a>
                    <form action="{{ route('donations.destroy', $donation) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-400 text-white font-semibold py-2 px-4 rounded-md hover:bg-red-500 transition duration-150 ease-in-out" style="background-color: #F87171; color: white; padding: 8px 16px; border-radius: 4px;" onclick="return confirm('Are you sure you want to delete this donation?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>