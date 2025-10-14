@extends('back.layout')

@section('content')
<div class="min-vh-100" style="background-color: #f8f9fa;">
    <div class="container py-5">
        <div class="card shadow-lg border-0 mx-auto" style="max-width: 1200px; width: 100%; border-radius: 1rem;">
            
            <!-- Header -->
            <div class="card-header bg-success text-white text-center py-4" style="border-radius: 1rem 1rem 0 0;">
                <h2 class="fw-bold mb-0">Edit Category ♻️</h2>
            </div>

            <div class="card-body p-5">
                <!-- Error & Success Alerts -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('waste_categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Category Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name', $category->name) }}" 
                                class="form-control" 
                                placeholder="Enter category name..." 
                                required>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="3" 
                                class="form-control" 
                                placeholder="Enter a short description..." 
                                required>{{ old('description', $category->description) }}</textarea>
                        </div>

                        <!-- Recycling Instructions -->
                        <div class="col-12">
                            <label for="recycling_instructions" class="form-label fw-semibold">Recycling Instructions</label>
                            <textarea 
                                name="recycling_instructions" 
                                id="recycling_instructions" 
                                rows="3" 
                                class="form-control" 
                                placeholder="How to recycle this waste type..." 
                                required>{{ old('recycling_instructions', $category->recycling_instructions) }}</textarea>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="text-center mt-5">
                        <a href="{{ route('waste_categories.index') }}" class="btn btn-secondary px-4 me-2">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-save me-1"></i> Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
