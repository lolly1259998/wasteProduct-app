@extends('back.layout')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-teal-100 dark:from-zinc-800 dark:to-zinc-900">
    <div class="container py-8">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h1 class="text-2xl font-bold mb-6 text-green-700 dark:text-green-300 text-center">Donation #{{ $donation->id }}</h1>
                        @if (session('success'))
                            <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 border-l-2 border-green-500 dark:border-green-700 text-green-700 dark:text-green-200 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="space-y-4">
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">User</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ $donation->user ? $donation->user->name : 'Guest' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Waste Type</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ \App\Http\Controllers\DonationController::getWasteTypeName($donation->waste_id) }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Item Name</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ $donation->item_name }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Condition</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ ucfirst($donation->condition) }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Status</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">
                                    <span class="badge bg-{{ $donation->status->color ?? 'secondary' }}">{{ ucfirst($donation->status->value) }}</span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Description</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ $donation->description ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Pickup</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ $donation->pickup_required ? 'Yes: ' . ($donation->pickup_address ?? 'N/A') : 'No' }}</p>
                            </div>
                            @if($donation->images && is_array($donation->images) && count($donation->images) > 0)
                                <div class="mb-3">
                                    <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Images</label>
                                    <div class="mt-2 space-y-2">
                                        @foreach($donation->images as $image)
                                            <img src="{{ Storage::url($image) }}" alt="Donation Image" class="max-w-[200px] rounded border border-teal-300">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-6 gap-2">
                            <div class="d-flex gap-2">
                                <a href="{{ route('back.donations.index') }}" class="btn btn-secondary btn-md">Back</a>
                                <a href="{{ route('back.donations.edit', $donation) }}" class="btn btn-warning btn-md">Update</a>
                            </div>
                            <form action="{{ route('back.donations.destroy', $donation) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-md" onclick="return confirm('Are you sure you want to delete this donation?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection