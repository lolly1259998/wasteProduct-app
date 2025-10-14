{{-- resources/views/front/donations/edit.blade.php --}}
@extends('front.layout')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-gradient text-dark" style="background: linear-gradient(to bottom right, #d4edda, #c3e6cb);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h1 class="text-2xl fw-bold mb-4 text-success text-center">Edit Donation ♻️</h1>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ $updateRoute }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            
                            {{-- Hidden user_id for current authenticated user --}}
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                            {{-- Hidden status to satisfy validation (admin-only change) --}}
                            <input type="hidden" name="status" value="{{ $donation->status->value ?? old('status') }}">

                            <div class="mb-3">
                                <label for="waste_id" class="form-label fw-semibold">Waste Type</label>
                                <select name="waste_id" id="waste_id" class="form-select" required>
                                    <option value="">Select Waste Type</option>
                                    @if(isset($wastes) && !empty($wastes))
                                        @foreach($wastes as $id => $waste)
                                            <option value="{{ $id }}" {{ ($donation->waste_id ?? old('waste_id')) == $id ? 'selected' : '' }}>{{ $waste['name'] }}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No waste types available</option>
                                    @endif
                                </select>
                                @error('waste_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status Display (Read-Only) --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <input type="text" class="form-control bg-secondary text-white" value="{{ $donation->status->value ?? 'N/A' }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="item_name" class="form-label fw-semibold">Item Name</label>
                                <input type="text" name="item_name" id="item_name" value="{{ $donation->item_name ?? old('item_name') }}" class="form-control" required>
                                @error('item_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="condition" class="form-label fw-semibold">Condition</label>
                                <select name="condition" id="condition" class="form-select" required>
                                    <option value="">Select Condition</option>
                                    <option value="new" {{ ($donation->condition ?? old('condition')) == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="used" {{ ($donation->condition ?? old('condition')) == 'used' ? 'selected' : '' }}>Used</option>
                                    <option value="damaged" {{ ($donation->condition ?? old('condition')) == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                </select>
                                @error('condition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Description</label>
                                <textarea name="description" id="description" rows="3" class="form-control">{{ $donation->description ?? old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Existing Images Display --}}
                            @if($donation->images && is_array($donation->images) && count($donation->images) > 0)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Current Images</label>
                                    <div class="row mb-2">
                                        @foreach($donation->images as $image)
                                            <div class="col-md-4 mb-2">
                                                <img src="{{ Storage::url($image) }}" alt="Current Image" class="img-thumbnail w-100" style="max-height: 100px;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="images" class="form-label fw-semibold">Add/Replace Images (Optional)</label>
                                <input type="file" name="images[]" id="images" multiple class="form-control">
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" name="pickup_required" id="pickup_required" class="form-check-input" value="1" {{ ($donation->pickup_required ?? old('pickup_required')) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="pickup_required">Pickup Required?</label>
                                @error('pickup_required')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pickup_address" class="form-label fw-semibold">Pickup Address (if required)</label>
                                <input type="text" name="pickup_address" id="pickup_address" value="{{ $donation->pickup_address ?? old('pickup_address') }}" class="form-control">
                                @error('pickup_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                <a href="{{ route($indexRoute) }}" class="btn btn-secondary">Back to List</a>
                                <button type="submit" class="btn btn-success">Update Donation</button>
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