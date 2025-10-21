@extends('back.layout')

@section('content')
<div class="min-vh-100 d-flex justify-content-center align-items-center" style="background-color: #f8f9fa;">
    <div class="container py-5">
        <div class="card shadow-lg border-0 mx-auto" style="max-width: 1000px; width: 100%; border-radius: 1rem;">
            
            <!-- Header -->
            <div class="card-header bg-success text-white text-center py-4" style="border-radius: 1rem 1rem 0 0;">
                <h2 class="fw-bold mb-0">AI Recycling Advice ♻️</h2>
            </div>

            <div class="card-body p-5">
                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Advice Form -->
                <form action="{{ route('ai.advice.recycling') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <!-- Waste Type -->
                        <div class="col-md-6">
                            <label for="type" class="form-label fw-semibold">Waste Type</label>
                            <input type="text" name="type" id="type" class="form-control" placeholder="e.g., Plastic, Paper" required>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <label for="category" class="form-label fw-semibold">Category</label>
                            <input type="text" name="category" id="category" class="form-control" placeholder="e.g., Recyclable, Organic" required>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-lightbulb me-2"></i>Get AI Advice
                        </button>
                    </div>
                </form>

                <!-- AI Advice Result -->
                @if(isset($advice))
                <div class="alert alert-success text-center mt-5" role="alert">
                    <h5 class="fw-bold mb-0">AI Advice:</h5>
                    <p class="mt-2 mb-0">{{ $advice }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
