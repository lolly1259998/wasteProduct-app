@extends('front.layout')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center text-success">Waste List</h1>

    @if($wastes->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-trash"></i>
            </div>
            <h3 class="mb-3">No wastes available</h3>
            <p class="text-muted mb-4">There are currently no waste items available.</p>
        </div>
    @else
        <div class="row">
            @foreach($wastes as $waste)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="waste-card card h-100 shadow">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-trash me-2"></i>{{ $waste->type }}
                            </h5>
                        </div>
                        
                        @if($waste->image_path)
                        <div class="text-center p-3">
                            <img src="{{ asset('storage/' . $waste->image_path) }}" 
                                 alt="{{ $waste->type }}" 
                                 class="waste-image img-fluid rounded"
                                 style="max-height: 200px; object-fit: cover;">
                        </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="waste-info mb-3">
                                <div class="info-item d-flex justify-content-between mb-2">
                                    <span class="text-muted"><i class="fas fa-weight me-2"></i>Weight:</span>
                                    <span class="fw-bold text-dark">{{ $waste->weight }} kg</span>
                                </div>
                                
                                <div class="info-item d-flex justify-content-between mb-2">
                                    <span class="text-muted"><i class="fas fa-tag me-2"></i>Status:</span>
                                    <span class="fw-bold text-dark">{{ $waste->status }}</span>
                                </div>
                                
                                <div class="info-item d-flex justify-content-between mb-3">
                                    <span class="text-muted"><i class="fas fa-folder me-2"></i>Category:</span>
                                    <span class="fw-bold text-dark">{{ $waste->category->name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            @if($waste->description)
                            <div class="waste-description mb-3">
                                <p class="card-text small text-muted">
                                    <i class="fas fa-align-left me-2"></i>
                                    {{ Str::limit($waste->description, 100) }}
                                </p>
                            </div>
                            @endif

                            <!-- Show Details Button -->
                            <div class="mt-auto">
                                <button class="btn btn-success w-100" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#wasteModal{{ $waste->id }}">
                                    <i class="fas fa-eye me-2"></i>Show Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Waste Details -->
                <div class="modal fade" id="wasteModal{{ $waste->id }}" tabindex="-1" 
                     aria-labelledby="wasteModalLabel{{ $waste->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="wasteModalLabel{{ $waste->id }}">
                                    <i class="fas fa-trash me-2"></i>{{ $waste->type }} Details
                                </h5>
                                <button type="button" class="btn-close btn-close-white" 
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <!-- Waste Image -->
                                    @if($waste->image_path)
                                    <div class="col-md-6 mb-4">
                                        <div class="text-center">
                                            <img src="{{ asset('storage/' . $waste->image_path) }}" 
                                                 alt="{{ $waste->type }}" 
                                                 class="img-fluid rounded shadow"
                                                 style="max-height: 300px; object-fit: cover;">
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <div class="{{ $waste->image_path ? 'col-md-6' : 'col-md-12' }}">
                                        <!-- Basic Information -->
                                        <div class="info-section mb-4">
                                            <h6 class="text-success mb-3">
                                                <i class="fas fa-info-circle me-2"></i>Basic Information
                                            </h6>
                                            <div class="row">
                                                <div class="col-6 mb-2 text-muted">
                                                    <strong>Type:</strong>
                                                </div>
                                                <div class="col-6 mb-2 text-dark">
                                                    {{ $waste->type }}
                                                </div>
                                                
                                                <div class="col-6 mb-2 text-muted">
                                                    <strong>Weight:</strong>
                                                </div>
                                                <div class="col-6 mb-2 text-dark">
                                                    {{ $waste->weight }} kg
                                                </div>
                                                
                                                <div class="col-6 mb-2 text-muted">
                                                    <strong>Status:</strong>
                                                </div>
                                                <div class="col-6 mb-2 text-dark">
                                                    {{ $waste->status }}
                                                </div>
                                                
                                                <div class="col-6 mb-2 text-muted">
                                                    <strong>Category:</strong>
                                                </div>
                                                <div class="col-6 mb-2 text-dark">
                                                    {{ $waste->category->name ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        @if($waste->description)
                                        <div class="info-section mb-4">
                                            <h6 class="text-success mb-3">
                                                <i class="fas fa-align-left me-2"></i>Description
                                            </h6>
                                            <p class="mb-0 text-dark">{{ $waste->description }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .waste-card {
        border: none;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .waste-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
        padding: 15px 20px;
    }

    .waste-image {
        transition: transform 0.3s ease;
    }

    .waste-card:hover .waste-image {
        transform: scale(1.05);
    }

    .info-item {
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 8px;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #9ca3af;
        margin-bottom: 20px;
    }

    .info-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #198754;
    }

    .modal-header {
        border-radius: 10px 10px 0 0;
    }

    .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .waste-description {
        border-left: 3px solid #198754;
        padding-left: 15px;
        background-color: #f8fff8;
        padding: 10px 15px;
        border-radius: 5px;
    }

    .text-dark {
        color: #212529 !important;
        font-weight: 500;
    }
</style>

<!-- Bootstrap JS for Modals -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional: Add some interactive features -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading animation to images
    const wasteImages = document.querySelectorAll('.waste-image');
    wasteImages.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.3s ease';
    });

    // Add click animation to buttons
    const detailButtons = document.querySelectorAll('.btn-success');
    detailButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
});
</script>
@endsection