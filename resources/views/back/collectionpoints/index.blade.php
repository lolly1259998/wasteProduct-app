@extends('back.layout')

@section('title', 'Points de Collecte')

@section('content')
<div class="container-fluid px-0">
    <!-- En-tête amélioré avec statistiques -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div class="mb-3 mb-md-0">
                    <h1 class="page-title text-success mb-2">
                        <i class="bi bi-recycle me-2"></i> Points de Collecte
                    </h1>
                    <p class="text-muted mb-0">Gérez l'ensemble des points de collecte de votre plateforme</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('collectionpoints.create') }}" class="btn btn-success shadow-sm fw-medium px-4 py-2">
                        <i class="bi bi-plus-circle me-2"></i> Ajouter un Point
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Cartes de statistiques -->
        <div class="col-12">
            <div class="row g-3 mb-4">
                @php
                    // Calcul des statistiques directement dans la vue
                    $activePoints = $collectionPoints->where('status', 'active')->count();
                    $inactivePoints = $collectionPoints->where('status', 'inactive')->count();
                    $undefinedPoints = $collectionPoints->whereNotIn('status', ['active', 'inactive'])->count();
                    $citiesCount = $collectionPoints->pluck('city')->unique()->filter()->count();
                @endphp
                
                <div class="col-md-3 col-sm-6">
                    <div class="card stat-card border-0 rounded-3 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Total Points</h6>
                                    <h3 class="text-success mb-0">{{ $collectionPoints->count() }}</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                    <i class="bi bi-recycle text-success fs-5"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-success bg-opacity-15 text-success">
                                    <i class="bi bi-arrow-up me-1"></i> Tous les points
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card stat-card border-0 rounded-3 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Points Actifs</h6>
                                    <h3 class="text-primary mb-0">{{ $activePoints }}</h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                    <i class="bi bi-check-circle text-primary fs-5"></i>
                                </div>
                            </div>
                     
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card stat-card border-0 rounded-3 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Points Inactifs</h6>
                                    <h3 class="text-warning mb-0">{{ $inactivePoints }}</h3>
                                </div>
                                <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                                    <i class="bi bi-pause-circle text-warning fs-5"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-warning bg-opacity-15 text-warning">
                                    <i class="bi bi-pause me-1"></i> Hors service
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card stat-card border-0 rounded-3 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Villes</h6>
                                    <h3 class="text-info mb-0">{{ $citiesCount }}</h3>
                                </div>
                                <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                                    <i class="bi bi-geo-alt text-info fs-5"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-info bg-opacity-15 text-info">
                                    <i class="bi bi-map me-1"></i> Villes couvertes
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Messages flash améliorés --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5 flex-shrink-0"></i>
            <div class="flex-grow-1">
                <span class="fw-medium">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5 flex-shrink-0"></i>
            <div class="flex-grow-1">
                <span class="fw-medium">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($collectionPoints->isEmpty())
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox display-4 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">Aucun point de collecte trouvé</h4>
                <p class="text-muted mb-4">Commencez par ajouter votre premier point de collecte</p>
                <a href="{{ route('collectionpoints.create') }}" class="btn btn-success px-4">
                    <i class="bi bi-plus-circle me-2"></i> Créer un point de collecte
                </a>
            </div>
        </div>
    @else
        <!-- Tableau amélioré -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <h5 class="card-title mb-2 mb-md-0 text-success fw-medium">
                        <i class="bi bi-list-ul me-2"></i> Liste des points de collecte
                    </h5>
                    <div class="text-muted small">
                        Affichage: <span id="filteredCount">{{ $collectionPoints->count() }}</span>/{{ $collectionPoints->count() }} point(s)
                    </div>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="collectionPointsTable">
                        <thead class="table-success">
                            <tr>
                                <th class="ps-4 sortable" data-sort="name">Nom <i class="bi bi-arrow-down-up ms-1"></i></th>
                                <th class="d-none d-sm-table-cell sortable" data-sort="address">Adresse <i class="bi bi-arrow-down-up ms-1"></i></th>
                                <th class="sortable" data-sort="city">Ville <i class="bi bi-arrow-down-up ms-1"></i></th>
                                <th class="d-none d-md-table-cell">Code Postal</th>
                                <th class="d-none d-lg-table-cell">Coordonnées</th>
                                <th>Horaires</th>
                                <th class="d-none d-md-table-cell">Catégories</th>
                                <th class="d-none d-lg-table-cell">Contact</th>
                                <th class="sortable" data-sort="status">Statut <i class="bi bi-arrow-down-up ms-1"></i></th>
                                <th class="text-center pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collectionPoints as $collectionPoint)
                                <tr class="position-relative collection-point-row" 
                                    data-name="{{ strtolower($collectionPoint->name) }}"
                                    data-city="{{ strtolower($collectionPoint->city) }}"
                                    data-status="{{ $collectionPoint->status ?? 'non_defini' }}"
                                    data-address="{{ strtolower($collectionPoint->address) }}">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="bi bi-recycle text-success"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-medium text-dark">{{ $collectionPoint->name }}</h6>
                                                <small class="text-muted">ID: {{ $collectionPoint->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;">
                                            {{ $collectionPoint->address }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $collectionPoint->city }}</span>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <code class="text-dark">{{ $collectionPoint->postal_code }}</code>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        @if($collectionPoint->latitude && $collectionPoint->longitude)
                                            <small class="text-muted d-block">
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {{ number_format($collectionPoint->latitude, 6) }}
                                            </small>
                                            <small class="text-muted d-block">
                                                <i class="bi bi-geo me-1"></i>
                                                {{ number_format($collectionPoint->longitude, 6) }}
                                            </small>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-25 text-secondary">Non défini</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $openingHours = $collectionPoint->opening_hours;
                                            if (is_string($openingHours)) {
                                                $openingHours = json_decode($openingHours, true);
                                            }
                                        @endphp
                                        
                                        @if (is_array($openingHours) && !empty($openingHours))
                                            <button class="btn btn-sm btn-outline-info border-0" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-html="true"
                                                    title="<strong>Horaires:</strong><br>@foreach($openingHours as $horaire)• {{ $horaire }}<br>@endforeach">
                                                <i class="bi bi-clock"></i>
                                            </button>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-25 text-secondary">Non défini</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        @php
                                            $categories = $collectionPoint->accepted_categories;
                                            if (is_string($categories)) {
                                                $categories = json_decode($categories, true);
                                            }
                                        @endphp
                                        
                                        @if (is_array($categories) && !empty($categories))
                                            <div class="d-flex flex-wrap gap-1" style="max-width: 150px;">
                                                @foreach(array_slice($categories, 0, 2) as $category)
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small">
                                                        {{ $category }}
                                                    </span>
                                                @endforeach
                                                @if(count($categories) > 2)
                                                    <span class="badge bg-light text-muted border small" data-bs-toggle="tooltip" 
                                                          title="{{ implode(', ', array_slice($categories, 2)) }}">
                                                        +{{ count($categories) - 2 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-25 text-secondary">Non défini</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        @if($collectionPoint->contact_phone)
                                            <div class="d-flex flex-column">
                                                <a href="tel:{{ $collectionPoint->contact_phone }}" class="text-decoration-none text-dark">
                                                    <i class="bi bi-telephone me-1"></i>{{ $collectionPoint->contact_phone }}
                                                </a>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-25 text-secondary">Non défini</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php $status = $collectionPoint->status ?? 'non_defini'; @endphp
                                        @if ($status === 'active')
                                            <span class="badge bg-success bg-opacity-15 text-success border border-success border-opacity-25 d-flex align-items-center" style="width: fit-content;">
                                                <i class="bi bi-check-circle me-1 small"></i> Actif
                                            </span>
                                        @elseif ($status === 'inactive')
                                            <span class="badge bg-secondary bg-opacity-15 text-secondary border border-secondary border-opacity-25 d-flex align-items-center" style="width: fit-content;">
                                                <i class="bi bi-x-circle me-1 small"></i> Inactif
                                            </span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-15 text-warning border border-warning border-opacity-25 d-flex align-items-center" style="width: fit-content;">
                                                <i class="bi bi-question-circle me-1 small"></i> Non défini
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="action-buttons">
                                        
                                            
                                            <!-- Bouton Modifier - Icône seule -->
<a href="{{ route('collectionpoints.edit', $collectionPoint->id) }}" 
   class="action-btn action-edit d-inline-flex align-items-center justify-content-center"
   data-bs-toggle="tooltip" 
   title="Modifier le point de collecte">
    <i class="bi bi-pencil-square"></i>
</a>

<!-- Bouton Supprimer - Icône seule -->
<form action="{{ route('collectionpoints.destroy', $collectionPoint->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" 
            class="action-btn action-delete d-inline-flex align-items-center justify-content-center"
            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce point de collecte ?')"
            data-bs-toggle="tooltip" 
            title="Supprimer le point de collecte">
        <i class="bi bi-trash3"></i>
    </button>
</form>


                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pied de tableau -->
            <div class="card-footer bg-white py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="text-muted small mb-2 mb-md-0">
                        Affichage de <strong id="displayCount">{{ $collectionPoints->count() }}</strong> point(s) de collecte sur <strong>{{ $collectionPoints->count() }}</strong>
                    </div>
                    <div class="text-muted small">
                        Dernière mise à jour: {{ now()->format('d/m/Y à H:i') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>



<style>
.page-title {
    font-weight: 600;
    font-size: 1.75rem;
}

.card {
    border: none;
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-1px);
}

.stat-card {
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

.table {
    margin-bottom: 0;
}

.table th {
    border-bottom: 2px solid #198754;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 0.75rem;
}

.table th.sortable {
    cursor: pointer;
    transition: background-color 0.2s;
}

.table th.sortable:hover {
    background-color: rgba(25, 135, 84, 0.05);
}

.table th.sorted-asc, .table th.sorted-desc {
    background-color: rgba(25, 135, 84, 0.1);
}

.table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
    border-bottom: 1px solid #f0f0f0;
}

.table tbody tr:hover {
    background-color: rgba(25, 135, 84, 0.02);
}

.badge {
    font-weight: 500;
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

/* Design moderne pour les boutons d'action */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    align-items: center;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 8px;
    border: none;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.action-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.action-btn:hover::before {
    left: 100%;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    border: none;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.85rem;
    font-weight: 500;
    position: relative;
    overflow: hidden;
    color: #fff !important;
}

.action-btn i {
    font-size: 1rem;
    transition: transform 0.2s ease;
}

.action-btn:hover i {
    transform: scale(1.1);
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

/* Couleurs */
.action-edit {
    background: linear-gradient(135deg, #ffc107, #e0a800);
}
.action-edit:hover {
    background: linear-gradient(135deg, #e0a800, #c69500);
}

.action-delete {
    background: linear-gradient(135deg, #dc3545, #c82333);
}
.action-delete:hover {
    background: linear-gradient(135deg, #c82333, #a71e2a);
}



/* Animation pour les lignes du tableau */
.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background-color: rgba(25, 135, 84, 0.04);
    box-shadow: inset 0 0 0 1px rgba(25, 135, 84, 0.1);
}

/* Style pour les icônes dans les badges */
.badge i {
    font-size: 0.7em;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-header .d-flex {
        flex-direction: column;
        align-items: stretch !important;
    }
    
    .card-header .d-flex > * {
        margin-bottom: 0.5rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .action-btn {
        width: 2rem;
        height: 2rem;
        font-size: 0.8rem;
    }
    
    .stat-card .card-body {
        padding: 1rem;
    }
}

/* Animation pour le filtrage */
.collection-point-row {
    transition: all 0.3s ease;
}

/* Style pour les champs de recherche et filtres */
.input-group-text {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.form-control:focus, .form-select:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
}

/* Amélioration des icônes d'action */
.action-btn i {
    font-size: 0.9rem;
    transition: transform 0.2s ease;
}

.action-btn:hover i {
    transform: scale(1.1);
}
</style>
@endsection