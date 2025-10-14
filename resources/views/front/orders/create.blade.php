{{-- resources/views/front/orders/create.blade.php --}}
@extends('front.layout')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-gradient text-dark" style="background: linear-gradient(to bottom right, #d4edda, #c3e6cb);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h1 class="text-2xl fw-bold mb-4 text-success text-center">
                            <i class="fas fa-shopping-cart me-2"></i>Place New Order
                        </h1>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success mb-4">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('front.orders.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            
                            <div class="mb-3">
                                <label for="user_id" class="form-label fw-semibold">
                                    <i class="fas fa-user me-1 text-muted"></i>User
                                </label>
                                <select name="user_id" id="user_id" class="form-select" required>
                                    <option value="">Select User</option>
                                    @foreach(\App\Models\User::all() as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="product_id" class="form-label fw-semibold">
                                    <i class="fas fa-tag me-1 text-muted"></i>Product
                                </label>
                                <select name="product_id" id="product_id" class="form-select" required>
                                    <option value="">Select Product</option>
                                    @if(isset($products) && !empty($products))
                                        @foreach($products as $id => $product)
                                            <option value="{{ $id }}" {{ old('product_id') == $id ? 'selected' : '' }}>{{ $product['name'] }} ({{ $product['price'] }})</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No products available</option>
                                    @endif
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label fw-semibold">
                                    <i class="fas fa-hashtag me-1 text-muted"></i>Quantity
                                </label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" class="form-control" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="shipping_address" class="form-label fw-semibold">
                                    <i class="fas fa-map-marker-alt me-1 text-muted"></i>Shipping Address
                                </label>
                                <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address') }}" class="form-control" required>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="payment_method" class="form-label fw-semibold">
                                    <i class="fas fa-credit-card me-1 text-muted"></i>Payment Method
                                </label>
                                <select name="payment_method" id="payment_method" class="form-select" required>
                                    <option value="">Select Method</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tracking_number" class="form-label fw-semibold">
                                    <i class="fas fa-route me-1 text-muted"></i>Tracking Number (Optional)
                                </label>
                                <input type="text" name="tracking_number" id="tracking_number" value="{{ old('tracking_number') }}" class="form-control">
                                @error('tracking_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                <a href="{{ route('front.orders.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane me-1"></i>Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Bootstrap validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endsection