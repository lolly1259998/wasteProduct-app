{{-- resources/views/back/donations/index.blade.php --}}
@extends('back.layout')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <h1 class="h3 font-weight-bold mb-4 text-success text-center">Manage Donations</h1>
                    @if (session('success'))
                        <div id="success-message" class="alert alert-success mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                        <script>
                            setTimeout(() => {
                                document.getElementById('success-message').style.display = 'none';
                            }, 3000);
                        </script>
                    @endif
                    
                    <!-- Add New Donation Button -->
                    <div class="text-start mb-4">
                        <a href="{{ route('back.donations.create') }}" class="btn btn-success">Add New Donation</a>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('back.donations.index') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-2">
                                <label class="form-label">Waste Type</label>
                                <select name="waste_id" class="form-select">
                                    <option value="">All Waste Types</option>
                                    @foreach($wastes as $id => $waste)
                                        <option value="{{ $id }}" {{ request('waste_id') == $id ? 'selected' : '' }}>{{ $waste['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Condition</label>
                                <select name="condition" class="form-select">
                                    <option value="">All Conditions</option>
                                    <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Used</option>
                                    <option value="damaged" {{ request('condition') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All Statuses</option>
                                    @foreach(\App\Enums\DonationStatus::cases() as $status)
                                        <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>{{ ucfirst($status->value) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Date From</label>
                                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Date To</label>
                                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success me-2">Filter</button>
                                <a href="{{ route('back.donations.index') }}" class="btn btn-outline-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Waste Type</th>
                                    <th>Item Name</th>
                                    <th>Condition</th>
                                    <th>Sentiment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($donations->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No donations found.</td>
                                    </tr>
                                @else
                                    @foreach($donations as $donation)
                                        <tr>
                                            <td>{{ $donation->id }}</td>
                                            <td>{{ $donation->user ? $donation->user->name : 'Guest' }}</td>
                                            <td>{{ \App\Http\Controllers\DonationController::getWasteTypeName($donation->waste_id) }}</td>
                                            <td>{{ $donation->item_name }}</td>
                                            <td>{{ ucfirst($donation->condition) }}</td>
                                            <td>
                                                @if(isset($sentiments[$donation->id]))
                                                    <span class="badge bg-{{ $sentiments[$donation->id] === 'positive' ? 'success' : ($sentiments[$donation->id] === 'negative' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($sentiments[$donation->id]) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td><span class="badge bg-info">{{ ucfirst($donation->status->value) }}</span></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('back.donations.show', $donation) }}" class="btn btn-warning btn-sm">View</a>
                                                    <a href="{{ route('back.donations.edit', $donation) }}" class="btn btn-outline-success btn-sm">Edit</a>
                                                    <form action="{{ route('back.donations.destroy', $donation) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this donation?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        @if ($donations->hasPages())
                            <nav aria-label="Donations pagination">
                                <ul class="pagination justify-content-center mt-4 mb-0 shadow-sm">
                                    {{-- Previous Page Link --}}
                                    @if ($donations->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link" style="background-color: #f8f9fa; border-color: #dee2e6; color: #6c757d; padding: 10px 20px;">
                                                <i class="fas fa-chevron-left me-1"></i>Previous
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $donations->previousPageUrl() }}" 
                                               style="background-color: #10b981; border-color: #10b981; color: white; font-weight: bold; padding: 10px 20px; transition: all 0.3s ease;">
                                                <i class="fas fa-chevron-left me-1"></i>Previous
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($donations->getUrlRange(1, $donations->lastPage()) as $page => $url)
                                        @if ($page == $donations->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link" style="background-color: #10b981; border-color: #10b981; font-weight: bold; padding: 10px 15px;">
                                                    {{ $page }}
                                                </span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}" 
                                                   style="background-color: white; border-color: #10b981; color: #10b981; font-weight: bold; padding: 10px 15px; transition: all 0.3s ease;">
                                                    {{ $page }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($donations->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $donations->nextPageUrl() }}" 
                                               style="background-color: #10b981; border-color: #10b981; color: white; font-weight: bold; padding: 10px 20px; transition: all 0.3s ease;">
                                                Next<i class="fas fa-chevron-right ms-1"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link" style="background-color: #f8f9fa; border-color: #dee2e6; color: #6c757d; padding: 10px 20px;">
                                                Next<i class="fas fa-chevron-right ms-1"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Pagination Hover Effects */
    .page-link:hover:not(.disabled):not(.active) {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    /* Responsive Pagination */
    @media (max-width: 576px) {
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
        .page-link {
            padding: 8px 15px !important;
            font-size: 0.875rem;
        }
    }
</style>
@endsection