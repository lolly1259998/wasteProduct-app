@extends('back.layout')

@section('content')
<div class="container py-5 fade-in-up">
    <div class="card border-0 shadow-sm rounded-4 p-4" style="max-width: 700px; margin: auto;">
        <!-- Header -->
        <div class="d-flex align-items-center mb-4 border-bottom pb-3">
            <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center me-3" style="width: 55px; height: 55px; font-size: 1.5rem;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h4 class="fw-bold text-success mb-0">Profile Information</h4>
                <small class="text-muted">Manage your account details securely</small>
            </div>
        </div>

        <!-- Profile Info -->
        <div class="mb-3">
            <p class="mb-1 fw-semibold text-dark"><i class="bi bi-person-fill me-2 text-success"></i> <strong>Name:</strong> {{ $user->name }}</p>
        </div>
        <div class="mb-3">
            <p class="mb-1 fw-semibold text-dark"><i class="bi bi-envelope-fill me-2 text-success"></i> <strong>Email:</strong> {{ $user->email }}</p>
        </div>

        @if(isset($user->role))
        <div class="mb-3">
            <p class="mb-1 fw-semibold text-dark">
                <i class="bi bi-shield-lock-fill me-2 text-success"></i> 
                <strong>Role:</strong> {{ $user->role->name ?? 'User' }}
            </p>
            @if(isset($user->role->description))
                <small class="text-muted">{{ $user->role->description }}</small>
            @endif
        </div>
        @endif

        <!-- Buttons -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ url('back/home') }}" class="btn btn-outline-success rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
            <a href="{{ route('logout') }}" class="btn btn-danger rounded-pill px-4">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </a>
        </div>
    </div>
</div>

<style>
.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(25px); }
    to { opacity: 1; transform: translateY(0); }
}
.card p {
    font-size: 1rem;
    line-height: 1.5;
}
.card strong {
    color: #14532d;
}
</style>
@endsection
