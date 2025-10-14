@extends('back.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-teal-100 dark:from-zinc-800 dark:to-zinc-900">
    <div class="container py-8">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h1 class="text-2xl font-bold mb-6 text-green-700 dark:text-green-300 text-center">Edit Donation</h1>
                        @if ($errors->any())
                            <div class="mb-4 p-3 bg-red-100 dark:bg-red-900 border-l-2 border-red-500 dark:border-red-700 text-red-700 dark:text-red-200 rounded">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 border-l-2 border-green-500 dark:border-green-700 text-green-700 dark:text-green-200 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ $updateRoute }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <!-- User -->
                            <div class="mb-3">
                                <label for="user_id" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">User</label>
                                <select name="user_id" id="user_id" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ ($donation->user_id ?? old('user_id')) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Waste Type -->
                            <div class="mb-3">
                                <label for="waste_id" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Waste Type</label>
                                <select name="waste_id" id="waste_id" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                    @if(isset($wastes) && !empty($wastes))
                                        @foreach($wastes as $id => $waste)
                                            <option value="{{ $id }}" {{ ($donation->waste_id ?? old('waste_id')) == $id ? 'selected' : '' }}>{{ $waste['name'] }}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No waste types available</option>
                                    @endif
                                </select>
                                @error('waste_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Item Name -->
                            <div class="mb-3">
                                <label for="item_name" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Item Name</label>
                                <input type="text" name="item_name" id="item_name" value="{{ $donation->item_name ?? old('item_name') }}" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                @error('item_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Condition -->
                            <div class="mb-3">
                                <label for="condition" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Condition</label>
                                <select name="condition" id="condition" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                    <option value="new" {{ ($donation->condition ?? old('condition')) == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="used" {{ ($donation->condition ?? old('condition')) == 'used' ? 'selected' : '' }}>Used</option>
                                    <option value="damaged" {{ ($donation->condition ?? old('condition')) == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                </select>
                                @error('condition')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Description</label>
                                <textarea name="description" id="description" rows="3" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400">{{ $donation->description ?? old('description') }}</textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Existing Images -->
                            @if($donation->images && is_array($donation->images) && count($donation->images) > 0)
                                <div class="mb-3">
                                    <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Current Images</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($donation->images as $imagePath)
                                            <img src="{{ Storage::url($imagePath) }}" alt="Donation Image" class="w-20 h-20 object-cover rounded border">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <!-- New Images -->
                            <div class="mb-3">
                                <label for="images" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Add/Replace Images (Optional)</label>
                                <input type="file" name="images[]" id="images" multiple class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400">
                                <small class="text-muted">Upload new images to replace existing ones.</small>
                                @error('images.*')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Pickup Required -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="pickup_required" id="pickup_required" class="form-check-input" value="1" {{ ($donation->pickup_required ?? old('pickup_required')) ? 'checked' : '' }}>
                                <label class="form-check-label text-lg font-semibold text-gray-800 dark:text-gray-200" for="pickup_required">Pickup Required</label>
                                @error('pickup_required')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Pickup Address -->
                            <div class="mb-3">
                                <label for="pickup_address" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Pickup Address</label>
                                <input type="text" name="pickup_address" id="pickup_address" value="{{ $donation->pickup_address ?? old('pickup_address') }}" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400">
                                @error('pickup_address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Status (Admin-only field) -->
                            <div class="mb-3">
                                <label for="status" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Status</label>
                                <select name="status" id="status" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                    @foreach(\App\Enums\DonationStatus::cases() as $status)
                                        <option value="{{ $status->value }}" {{ ($donation->status ?? old('status')) == $status->value ? 'selected' : '' }}>{{ ucfirst($status->value) }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('back.donations.index') }}" class="btn btn-secondary btn-md">Cancel</a>
                                <button type="submit" class="btn btn-success btn-md">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection