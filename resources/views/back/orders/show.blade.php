{{-- resources/views/back/orders/show.blade.php --}}
@extends('back.layout')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <h1 class="h3 font-weight-bold mb-4 text-success text-center">Order #{{ $order->id }}</h1>
                    @if (session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">User</label>
                            <p class="form-control">{{ $order->user->name ?? 'Unknown' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Product</label>
                            <p class="form-control">{{ \App\Http\Controllers\OrderController::getProductName($order->product_id) }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Quantity</label>
                            <p class="form-control">{{ $order->quantity }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Total</label>
                            <p class="form-control">${{ $order->total_amount }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status :</label>
                                <span class="badge bg-info">{{ ucfirst($order->status->value) }}</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Order Date</label>
                            <p class="form-control">{{ $order->order_date->format('Y-m-d') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Shipping Address</label>
                            <p class="form-control">{{ $order->shipping_address }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Payment Method</label>
                            <p class="form-control">{{ ucfirst($order->payment_method) }}</p>
                        </div>
                        @if($order->tracking_number)
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tracking Number</label>
                                <p class="form-control">{{ $order->tracking_number }}</p>
                            </div>
                        @endif
                    </div>
                    <!-- Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-4 gap-2">
                        <a href="{{ route('back.orders.index') }}" class="btn btn-secondary">Back</a>
                        {{-- <a href="{{ route('back.orders.edit', $order) }}" class="btn btn-warning">Edit</a> --}}
                        <form action="{{ route('back.orders.destroy', $order) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection