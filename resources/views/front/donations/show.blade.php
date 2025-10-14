{{-- resources/views/front/donations/show.blade.php --}}
@extends('front.layout')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-gradient text-dark" style="background: linear-gradient(to bottom right, #d4edda, #c3e6cb);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h1 class="text-2xl fw-bold mb-4 text-success text-center">
                            <i class="fas fa-recycle me-2"></i>Donation #{{ $donation->id }}
                        </h1>
                        
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="space-y-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user me-1 text-muted"></i>User
                                </label>
                                <p class="form-control">{{ $donation->user->name ?? 'Guest' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-trash-alt me-1 text-muted"></i>Waste Type
                                </label>
                                <p class="form-control">{{ \App\Http\Controllers\DonationController::getWasteTypeName($donation->waste_id) }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-tag me-1 text-muted"></i>Item Name
                                </label>
                                <p class="form-control fw-semibold">{{ $donation->item_name }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-info-circle me-1 text-muted"></i>Condition
                                </label>
                                <p class="form-control">{{ ucfirst($donation->condition) }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-exclamation-circle me-1 text-muted"></i>Status
                                </label>
                                    <span class="badge @switch($donation->status->value)
                                        @case('available') bg-success @break
                                        @case('claimed') bg-primary @break
                                        @case('completed') bg-info @break
                                        @case('cancelled') bg-danger @break
                                        @default bg-secondary
                                    @endswitch">
                                        {{ $donation->status->value }}
                                    </span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-align-left me-1 text-muted"></i>Description
                                </label>
                                <p class="form-control">{{ $donation->description ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-truck me-1 text-muted"></i>Pickup
                                </label>
                                <p class="form-control">{{ $donation->pickup_required ? 'Yes: ' . ($donation->pickup_address ?? 'N/A') : 'No' }}</p>
                            </div>
                            @if($donation->images && is_array($donation->images) && count($donation->images) > 0)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-images me-1 text-muted"></i>Images
                                    </label>
                                    <div class="row g-2">
                                        @foreach($donation->images as $index => $image)
                                            <div class="col-6 col-md-4 col-lg-3">
                                                <img src="{{ Storage::url($image) }}" alt="Donation Image" class="img-fluid rounded shadow-sm w-100" style="height: 150px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 gap-2">
                            <div class="d-flex gap-2">
                                <a href="{{ route($indexRoute) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Back to List
                                </a>
                            </div>
                            @auth
                            @if($donation->user_id == auth()->id())
                          
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hover & Responsive Fluidity */
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12) !important;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    @media (max-width: 768px) {
        .space-y-4 > * { margin-bottom: 1rem !important; }
        .d-flex.gap-2 { flex-direction: column; }
        .btn { width: 100%; margin-bottom: 0.5rem; }
        .col-md-4 { margin-bottom: 1rem; }
    }

    /* Custom badge styles */
    .badge {
        font-size: 0.75rem;
        padding: 0.4em 0.7em;
        border-radius: 0.375rem;
    }

    /* Image responsiveness */
    img {
        transition: transform 0.3s ease;
    }
    img:hover {
        transform: scale(1.05);
    }
</style>
@endsection