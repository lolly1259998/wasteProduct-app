@extends('back.layout')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-teal-100 dark:from-zinc-800 dark:to-zinc-900">
    <div class="container py-8">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h1 class="text-2xl font-bold mb-6 text-green-700 dark:text-green-300 text-center">Manage Donations</h1>
                        @if (session('success'))
                            <div id="success-message" class="mb-4 p-3 bg-green-100 dark:bg-green-900 border-l-2 border-green-500 dark:border-green-700 text-green-700 dark:text-green-200 rounded">
                                {{ session('success') }}
                            </div>
                            <script>
                                setTimeout(() => {
                                    document.getElementById('success-message').style.display = 'none';
                                }, 3000);
                            </script>
                        @endif
                        
                        <!-- Add New Donation Button -->
                        <div class="text-left mb-6">
                            <a href="{{ route('back.donations.create') }}" class="btn btn-success btn-md">Add New Donation</a>
                        </div>

                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('back.donations.index') }}" class="mb-8">
                            <div class="flex flex-col md:flex-row md:items-end gap-4">
                                <div class="flex flex-col md:flex-row gap-4 flex-1">
                                    <select name="waste_id" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white flex-1">
                                        <option value="">All Waste Types</option>
                                        @foreach($wastes as $id => $waste)
                                            <option value="{{ $id }}" {{ request('waste_id') == $id ? 'selected' : '' }}>{{ $waste['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <select name="condition" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white flex-1">
                                        <option value="">All Conditions</option>
                                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Used</option>
                                        <option value="damaged" {{ request('condition') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                    </select>
                                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white flex-1">
                                        <option value="">All Statuses</option>
                                        @foreach(\App\Enums\DonationStatus::cases() as $status)
                                            <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>{{ ucfirst($status->value) }}</option>
                                        @endforeach
                                    </select>
                                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white flex-1">
                                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white flex-1">
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="submit" class="btn btn-primary btn-md">Filter</button>
                                    <a href="{{ route('back.donations.index') }}" class="btn btn-secondary btn-md">Reset</a>
                                </div>
                            </div>
                        </form>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse">
                                <thead>
                                    <tr class="bg-gray-200 dark:bg-zinc-700">
                                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">ID</th>
                                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">User</th>
                                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Waste Type</th>
                                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Item Name</th>
                                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Condition</th>
                                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Status</th>
                                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-300">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($donations->isEmpty())
                                        <tr>
                                            <td colspan="7" class="px-4 py-2 text-center text-gray-600 dark:text-gray-400">No donations found.</td>
                                        </tr>
                                    @else
                                        @foreach($donations as $donation)
                                            <tr class="border-b dark:border-zinc-600">
                                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $donation->id }}</td>
                                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $donation->user ? $donation->user->name : 'Guest' }}</td>
                                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ \App\Http\Controllers\DonationController::getWasteTypeName($donation->waste_id) }}</td>
                                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $donation->item_name }}</td>
                                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $donation->condition }}</td>
                                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $donation->status->value }}</td>
                                                <td class="px-4 py-2">
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ route('back.donations.show', $donation) }}" class="btn btn-warning btn-sm">View</a>
                                                        <form action="{{ route('back.donations.destroy', $donation) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this donation?')">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $donations->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection