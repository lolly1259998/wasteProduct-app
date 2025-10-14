{{-- resources/views/front/orders/show.blade.php --}}
@extends('front.layout')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-gradient text-dark" style="background: linear-gradient(to bottom right, #d4edda, #c3e6cb);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h1 class="text-2xl fw-bold mb-4 text-success text-center">
                            <i class="fas fa-shopping-cart me-2"></i>Order Details #{{ $order->id }}
                        </h1>
                        
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-success mb-3">
                                    <i class="fas fa-info-circle me-1 text-muted"></i>Overview
                                </h6>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-user me-1 text-muted"></i>User
                                    </label>
                                    <p class="form-control">{{ $order->user->name ?? 'Guest' }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-tag me-1 text-muted"></i>Product
                                    </label>
                                    <p class="form-control">{{ \App\Http\Controllers\OrderController::getProductName($order->product_id) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-hashtag me-1 text-muted"></i>Quantity
                                    </label>
                                    <p class="form-control">{{ $order->quantity }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-dollar-sign me-1 text-muted"></i>Total Amount
                                    </label>
                                    <p class="form-control fw-bold text-success">${{ number_format($order->total_amount, 2) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-exclamation-circle me-1 text-muted"></i>Status
                                    </label>
                                        <span class="badge @switch($order->status->value)
                                            @case('completed') bg-success @break
                                            @case('processing') bg-primary @break
                                            @case('pending') bg-warning @break
                                            @case('cancelled') bg-danger @break
                                            @default bg-secondary
                                        @endswitch">
                                            {{ $order->status->value }}
                                        </span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar me-1 text-muted"></i>Order Date
                                    </label>
                                    <p class="form-control">{{ $order->order_date->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-success mb-3">
                                    <i class="fas fa-truck me-1 text-muted"></i>Shipping & Payment
                                </h6>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-map-marker-alt me-1 text-muted"></i>Shipping Address
                                    </label>
                                    <p class="form-control">{{ $order->shipping_address }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-credit-card me-1 text-muted"></i>Payment Method
                                    </label>
                                    <p class="form-control">{{ ucfirst($order->payment_method) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-route me-1 text-muted"></i>Tracking Number
                                    </label>
                                    <p class="form-control">{{ $order->tracking_number ?? 'Not available' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('front.orders.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Orders
                            </a>
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
        .row > .col-md-6 {
            margin-bottom: 2rem;
        }
        .space-y-4 > * { 
            margin-bottom: 1rem !important; 
        }
        .d-flex.gap-2 { 
            flex-direction: column; 
        }
        .btn { 
            width: 100%; 
            margin-bottom: 0.5rem; 
        }
    }

    /* Custom badge styles */
    .badge {
        font-size: 0.75rem;
        padding: 0.4em 0.7em;
        border-radius: 0.375rem;
    }
</style>
@endsection