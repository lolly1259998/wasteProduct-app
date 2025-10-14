@extends('back.layout')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-teal-100 dark:from-zinc-800 dark:to-zinc-900">
    <div class="container py-8">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h1 class="text-2xl font-bold mb-6 text-green-700 dark:text-green-300 text-center">Create Order</h1>
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
                        <form action="{{ route('back.orders.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <!-- User -->
                            <div class="mb-3">
                                <label for="user_id" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">User</label>
                                <select name="user_id" id="user_id" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                    @foreach(\App\Models\User::all() as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Product -->
                            <div class="mb-3">
                                <label for="product_id" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Product</label>
                                <select name="product_id" id="product_id" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                    @if(isset($products) && !empty($products))
                                        @foreach($products as $id => $product)
                                            <option value="{{ $id }}" {{ old('product_id') == $id ? 'selected' : '' }}>{{ $product['name'] }}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled selected>No products available</option>
                                    @endif
                                </select>
                                @error('product_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Quantity -->
                            <div class="mb-3">
                                <label for="quantity" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Quantity</label>
                                <input type="number" min="1" name="quantity" id="quantity" value="{{ old('quantity') }}" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                @error('quantity')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Shipping Address -->
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Shipping Address</label>
                                <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address') }}" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                @error('shipping_address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Payment Method -->
                            <div class="mb-3">
                                <label for="payment_method" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Payment Method</label>
                                <select name="payment_method" id="payment_method" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                </select>
                                @error('payment_method')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Tracking Number -->
                            <div class="mb-3">
                                <label for="tracking_number" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Tracking Number (Optional)</label>
                                <input type="text" name="tracking_number" id="tracking_number" value="{{ old('tracking_number') }}" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400">
                                @error('tracking_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('back.orders.index') }}" class="btn btn-secondary btn-md">Cancel</a>
                                <button type="submit" class="btn btn-success btn-md">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection