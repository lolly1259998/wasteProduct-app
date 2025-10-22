@extends('front.layout')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center text-success">Waste Categories</h1>

    @if($categories->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-folder-open"></i>
            </div>
            <h3 class="mb-3">No categories available</h3>
            <p class="text-muted mb-4">There are currently no waste categories available.</p>
        </div>
    @else
        <div class="results-count">
            <i class="fas fa-info-circle me-2"></i>
            {{ $categories->count() }} category(ies) found
        </div>

        <div class="row">
            @foreach($categories as $category)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="collection-card card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-recycle me-2"></i>{{ $category->name }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text mb-3">{{ Str::limit($category->description, 100) }}</p>
                            
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Instructions: {{ Str::limit($category->recycling_instructions, 80) }}
                                </small>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#categoryModal{{ $category->id }}">
                                    <i class="fas fa-eye me-2"></i>
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal pour cette catégorie -->
                <div class="modal fade" id="categoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="categoryModalLabel{{ $category->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="categoryModalLabel{{ $category->id }}">
                                    <i class="fas fa-recycle me-2"></i>{{ $category->name }}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="text-success mb-3">
                                            <i class="fas fa-align-left me-2"></i>Description
                                        </h6>
                                        <p class="mb-4">{{ $category->description }}</p>

                                        <h6 class="text-success mb-3">
                                            <i class="fas fa-recycle me-2"></i>Recycling Instructions
                                        </h6>
                                        <p class="mb-4">{{ $category->recycling_instructions }}</p>

                                        @if($category->created_at)
                                            <div class="bg-light p-3 rounded">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    Créée le: {{ $category->created_at->format('d/m/Y') }}
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Cancel
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
    .collection-card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .collection-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .card-header {
        background-color: #198754;
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 15px 20px;
    }

    .card-title {
        margin: 0;
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

    .results-count {
        background-color: #e8f5e8;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        color: #065f46;
        font-weight: 500;
    }

    .modal-header {
        border-radius: 10px 10px 0 0;
    }

    .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
</style>

<!-- Script pour gérer les modals -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection