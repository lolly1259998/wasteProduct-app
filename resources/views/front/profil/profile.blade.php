@extends('front.global')

@section('title', 'Mon Profil')

@section('content')
<style>
    .profile-container {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        paddingაფ, padding: 40px 30px;
        max-width: 850px;
        margin: 60px auto;
        transition: all 0.3s ease-in-out;
    }

    .profile-container:hover {
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .profile-header img {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        border: 4px solid #198754;
        object-fit: cover;
    }

    .profile-header h3 {
        color: #198754;
        font-weight: 700;
        margin-top: 15px;
    }

    .profile-info {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 25px;
    }

    .info-card {
        flex: 1 1 calc(50% - 20px);
        background: #f8fdf9;
        border: 1px solid #e1f3e4;
        border-radius: 10px;
        padding: 20px;
        transition: 0.3s;
    }

    .info-card:hover {
        background: #e9fbee;
        transform: translateY(-3px);
    }

    .info-card i {
        color: #198754;
        font-size: 1.5rem;
    }

    .info-title {
        font-weight: 600;
        color: #333;
    }

    .info-text {
        color: #666;
        margin-top: 5px;
    }

    .profile-actions {
        text-align: center;
        margin-top: 30px;
    }

    .profile-actions .btn {
        border-radius: 30px;
        padding: 8px 25px;
        font-weight: 500;
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        <img src="{{ asset('images/cat.png') }}" alt="Profil">
        <h3>{{ $user->name }}</h3>
        <p class="text-muted">{{ $user->email }}</p>
        <span class="badge bg-success px-3 py-2">
            {{ $user->role ? ucfirst($user->role->name) : 'Citoyen' }}
        </span>
    </div>

    <div class="profile-info">
        <div class="info-card">
            <i class="bi bi-calendar-check"></i>
            <div class="info-title">Date d’inscription</div>
            <div class="info-text">{{ $user->created_at->format('d/m/Y') }}</div>
        </div>

        <div class="info-card">
            <i class="bi bi-shield-lock"></i>
            <div class="info-title">Mot de passe</div>
            <div class="info-text">********</div>
            <a href="{{ route('settings.password') }}" class="btn btn-sm btn-outline-success mt-2">Modifier</a>
        </div>

      

        <div class="info-card">
            <i class="bi bi-house-door"></i>
            <div class="info-title">Adresse</div>
            <div class="info-text">
                {{ $user->address ?? 'Aucune adresse enregistrée' }}
            </div>
        </div>
    </div>

    <div class="profile-actions">
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
            </button>
        </form>
    </div>
</div>
@endsection