@extends('back.layout')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-teal-100 dark:from-zinc-800 dark:to-zinc-900">
    <div class="container py-8">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h1 class="text-2xl font-bold mb-6 text-green-700 dark:text-green-300 text-center">Order #{{ $order->id }}</h1>
                        @if (session('success'))
                            <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 border-l-2 border-green-500 dark:border-green-700 text-green-700 dark:text-green-200 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="space-y-4">
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">User</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ $order->user->name ?? 'Unknown' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Product</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ \App\Http\Controllers\OrderController::getProductName($order->product_id) }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Quantity</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ $order->quantity }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Total</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">${{ $order->total_amount }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Status</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ $order->status }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Order Date</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ $order->order_date->format('Y-m-d') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Shipping Address</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ $order->shipping_address }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Payment Method</label>
                                <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ $order->payment_method }}</p>
                            </div>
                            @if($order->tracking_number)
                                <div class="mb-3">
                                    <label class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Tracking Number</label>
                                    <p class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600">{{ $order->tracking_number }}</p>
                                </div>
                            @endif
                        </div>
                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-6">
                            <a href="{{ route('back.orders.index') }}" class="btn btn-secondary btn-md">
                                <x-heroicon-o-arrow-left class="h-4 w-4 inline mr-2" />
                                Back
                            </a>
                            {{-- <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning btn-md">
                                <x-heroicon-o-pencil class="h-4 w-4 inline mr-2" />
                                Edit
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection