{{-- resources/views/back/donations/show.blade.php --}}
@extends('back.layout')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card shadow">
                <div class="card-body p-3 p-md-4">
                    <h1 class="h3 fw-bold mb-4 text-success text-center">Donation #{{ $donation->id }}</h1>
                    @if (session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">User</label>
                            <p class="form-control">{{ $donation->user ? $donation->user->name : 'Guest' }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">Waste Type</label>
                            <p class="form-control">{{ \App\Http\Controllers\DonationController::getWasteTypeName($donation->waste_id) }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">Item Name</label>
                            <p class="form-control">{{ $donation->item_name }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">Condition</label>
                            <p class="form-control">{{ ucfirst($donation->condition) }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <p class="form-control">
                                <span class="badge bg-info">{{ ucfirst($donation->status->value) }}</span>
                            </p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">Pickup</label>
                            <p class="form-control">{{ $donation->pickup_required ? 'Yes: ' . ($donation->pickup_address ?? 'N/A') : 'No' }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Description</label>
                            <p class="form-control">{{ $donation->description ?? 'N/A' }}</p>
                        </div>
                        @if($donation->images && is_array($donation->images) && count($donation->images) > 0)
                            <div class="col-12">
                                <label class="form-label fw-bold">Images</label>
                                <div class="row g-2 mt-2">
                                    @foreach($donation->images as $image)
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <img src="{{ Storage::url($image) }}" alt="Donation Image" class="img-fluid rounded shadow-sm w-100" style="height: 150px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- Buttons -->
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mt-4">
                        <div class="d-flex gap-2 w-100 w-md-auto">
                            <a href="{{ route('back.donations.index') }}" class="btn btn-secondary w-100 w-md-auto">Back</a>
                            <a href="{{ route('back.donations.edit', $donation) }}" class="btn btn-warning w-100 w-md-auto">Update</a>
                        </div>
                        <form action="{{ route('back.donations.destroy', $donation) }}" method="POST" class="d-inline w-100 w-md-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this donation?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection