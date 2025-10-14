{{-- resources/views/front/donations/create.blade.php --}}
@extends('front.layout')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-gradient text-dark" style="background: linear-gradient(to bottom right, #d4edda, #c3e6cb);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h1 class="text-2xl fw-bold mb-4 text-success text-center">
                            <i class="fas fa-recycle me-2"></i>Make New Donation
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

                        <form action="{{ route($storeRoute) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            
                            {{-- Hidden user_id for current authenticated user --}}
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                            <div class="mb-3">
                                <label for="waste_id" class="form-label fw-semibold">
                                    <i class="fas fa-trash-alt me-1 text-muted"></i>Waste Type
                                </label>
                                <select name="waste_id" id="waste_id" class="form-select" required>
                                    <option value="">Select Waste Type</option>
                                    @if(isset($wastes) && !empty($wastes))
                                        @foreach($wastes as $id => $waste)
                                            <option value="{{ $id }}" {{ old('waste_id') == $id ? 'selected' : '' }}>{{ $waste['name'] }}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No waste types available</option>
                                    @endif
                                </select>
                                @error('waste_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="item_name" class="form-label fw-semibold">
                                    <i class="fas fa-tag me-1 text-muted"></i>Item Name
                                </label>
                                <input type="text" name="item_name" id="item_name" value="{{ old('item_name') }}" class="form-control" required>
                                @error('item_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="condition" class="form-label fw-semibold">
                                    <i class="fas fa-info-circle me-1 text-muted"></i>Condition
                                </label>
                                <select name="condition" id="condition" class="form-select" required>
                                    <option value="">Select Condition</option>
                                    <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Used</option>
                                    <option value="damaged" {{ old('condition') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                </select>
                                @error('condition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">
                                    <i class="fas fa-align-left me-1 text-muted"></i>Description
                                </label>
                                <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="images" class="form-label fw-semibold">
                                    <i class="fas fa-images me-1 text-muted"></i>Images (Multiple)
                                </label>
                                <input type="file" name="images[]" id="images" multiple class="form-control">
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" name="pickup_required" id="pickup_required" class="form-check-input" value="1" {{ old('pickup_required') ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="pickup_required">
                                    <i class="fas fa-truck me-1 text-muted"></i>Pickup Required?
                                </label>
                                @error('pickup_required')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pickup_address" class="form-label fw-semibold">
                                    <i class="fas fa-map-marker-alt me-1 text-muted"></i>Pickup Address (if required)
                                </label>
                                <input type="text" name="pickup_address" id="pickup_address" value="{{ old('pickup_address') }}" class="form-control">
                                @error('pickup_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                <a href="{{ route($indexRoute) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane me-1"></i>Donate
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