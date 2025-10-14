<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Points de Collecte - Économie Circulaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2e7d32;
            --primary-light: #4caf50;
            --primary-dark: #1b5e20;
            --accent-color: #ff9800;
            --text-dark: #333;
            --text-light: #666;
            --background-light: #f8f9fa;
            --card-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            --card-hover-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-light);
            color: var(--text-dark);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            padding: 3rem 0;
            border-radius: 0 0 30px 30px;
            margin-bottom: 3rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .page-title {
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }
        
        .page-subtitle {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            opacity: 0.9;
        }
        
        .collection-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            background: white;
            box-shadow: var(--card-shadow);
        }
        
        .collection-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--card-hover-shadow);
        }
        
        .card-header {
            background: linear-gradient(to right, var(--primary-color), var(--primary-light));
            color: white;
            padding: 1.2rem;
            border-bottom: none;
        }
        
        .card-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .location-info {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .location-icon {
            color: var(--primary-color);
            margin-right: 10px;
            margin-top: 3px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-active {
            background-color: rgba(46, 125, 50, 0.15);
            color: var(--primary-dark);
        }
        
        .status-inactive {
            background-color: rgba(158, 158, 158, 0.15);
            color: #757575;
        }
        
        .btn-success {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .alert-success {
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
        }
        
        .alert-warning {
            border-radius: 12px;
            border-left: 4px solid #ff9800;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
        }
        
        .empty-state-icon {
            font-size: 4rem;
            color: #ccc;
            margin-bottom: 1.5rem;
        }
        
        .search-filter-section {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }
        
        .filter-title {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            padding: 0.7rem 1rem;
            border: 1px solid #e0e0e0;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }
        
        .results-count {
            color: var(--text-light);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 0;
                border-radius: 0 0 20px 20px;
            }
            
            .page-title {
                font-size: 1.8rem;
            }
            
            .page-subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- En-tête de la page -->
    <section class="hero-section">
        <div class="container">
            <div class="text-center">
                <h1 class="page-title">Points de Collecte</h1>
                <p class="page-subtitle">Trouvez un point de collecte près de chez vous pour contribuer à l'économie circulaire et donner une seconde vie à vos objets.</p>
            </div>
        </div>
    </section>

    <div class="container mb-5">
        <!-- Message de succès -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        
        <!-- Vérification si des points de collecte existent -->
        @if ($collectionPoints->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h3 class="mb-3">Aucun point de collecte trouvé</h3>
                <p class="text-muted mb-4">Il n'y a actuellement aucun point de collecte actif dans votre région.</p>
                <button class="btn btn-outline-success">Suggérer un emplacement</button>
            </div>
        @else
            <div class="results-count">
                <i class="fas fa-info-circle me-2"></i>
                {{ $collectionPoints->count() }} point(s) de collecte trouvé(s)
            </div>
            
            <div class="row">
                @foreach ($collectionPoints as $collectionPoint)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="collection-card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ $collectionPoint->name }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="location-info">
                                    <i class="fas fa-map-marker-alt location-icon"></i>
                                    <div>
                                        <p class="mb-1 fw-semibold">{{ $collectionPoint->address }}</p>
                                        <p class="mb-2 text-muted">{{ $collectionPoint->city }}</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="status-badge {{ $collectionPoint->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                        <i class="fas fa-circle me-1" style="font-size: 0.6rem;"></i>
                                        {{ ucfirst($collectionPoint->status) }}
                                    </span>
                                    <span class="text-muted small">
                                        <i class="far fa-clock me-1"></i>
                                        Ouvert jusqu'à 18h
                                    </span>
                                </div>
                                
                                <div class="d-grid">
                                    <a href="{{ route('front.collectionpoints.show', $collectionPoint->id) }}" class="btn btn-success">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Voir les détails
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
           
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>