{{-- resources/views/back/reservations/create.blade.php --}}
@extends('back.layout')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <h1 class="h3 font-weight-bold mb-4 text-success text-center">Create Reservation</h1>
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4" role="alert">
                            <ul class="list-unstyled mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('back.reservations.store') }}" method="POST">
                        @csrf
                        <!-- User -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label fw-bold">User</label>
                            <select name="user_id" id="user_id" class="form-control" required>
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
                            <label for="product_id" class="form-label fw-bold">Product</label>
                            <select name="product_id" id="product_id" class="form-control" required>
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
                            <label for="quantity" class="form-label fw-bold">Quantity</label>
                            <input type="number" min="1" name="quantity" id="quantity" value="{{ old('quantity') }}" class="form-control" required>
                            @error('quantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Reserved Until -->
                        <div class="mb-3">
                            <label for="reserved_until" class="form-label fw-bold">Reserved Until</label>
                            <input type="datetime-local" name="reserved_until" id="reserved_until" value="{{ old('reserved_until') }}" class="form-control" required>
                            @error('reserved_until')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('back.reservations.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection