<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste2Product Dashboard - {{ $title ?? 'Admin' }}</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes utilisées -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: system-ui, sans-serif;
            overflow-x: hidden;
        }

        /* NAVBAR transparente au début */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            transition: background-color 0.4s ease, box-shadow 0.3s ease;
            background-color: transparent !important;
            z-index: 1000;
        }

        /* Quand on scrolle, elle devient verte */
        .navbar.scrolled {
            background-color: #198754 !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }

        .nav-link {
            color: #fff !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            text-decoration: underline;
            color: #a7f3d0 !important;
        }

        .hero-header {
            height: 80vh;
            background: url("{{ asset('images/Earth.png') }}") no-repeat center center/cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            color: white;
            padding-left: 100px;
        }

        .hero-header::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }

        .hero-content h1 {
            font-size: 2.8rem;
            font-weight: bold;
        }

        .hero-content span {
            color: #a7f3d0;
        }
       
        main {
            background: linear-gradient(120deg, #f8fff8, #f5fff2);
            padding-top: 80px;
        }

        footer {
            background-color: #198754;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        /* Styles pour les cartes de points de collecte */
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

        .location-info {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .location-icon {
            color: #198754;
            margin-right: 10px;
            margin-top: 3px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
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

        /* Responsive */
        @media (max-width: 768px) {
            .hero-header {
                padding-left: 20px;
                padding-right: 20px;
                justify-content: center;
                text-align: center;
            }
            
            .hero-content h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-recycle me-2"></i>
                Waste2Product
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
           <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="bi bi-house-door me-1"></i>Home
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/products') }}" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                        <i class="bi bi-bag-check me-1"></i>Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/waste2product/collectionpoints') }}" class="nav-link {{ request()->is('front.collectionpoints.index') ? 'active' : '' }}">
                        <i class="bi bi-geo-alt me-1"></i>collectionpoints
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/campaigns') }}" class="nav-link {{ request()->is('campaigns*') ? 'active' : '' }}">
                        <i class="bi bi-megaphone me-1"></i>Campaigns
                    </a>
                </li>

                <!-- Nouveau lien Waste Categories -->
                <li class="nav-item">
                    <a href="{{ route('front.waste-categories.index') }}" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
                        <i class="bi bi-grid-3x3-gap me-1"></i>Waste Categories
                    </a>
                </li>

                <!-- Nouveau lien Wastes -->
                <li class="nav-item">
                    <a href="{{ route('front.wastes.index') }}" class="nav-link {{ request()->is('wastess*') ? 'active' : '' }}">
                        <i class="bi bi-trash me-1"></i>Waste
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}">
                        <i class="bi bi-info-circle me-1"></i>About
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/contact') }}" class="nav-link {{ request()->is('contact') ? 'active' : '' }}">
                        <i class="bi bi-envelope me-1"></i>Contact
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/login') }}" class="nav-link text-light">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <!-- En-tête hero -->
    <header class="hero-header">
        <div class="hero-content">
            <h1>Transformons nos <span>déchets</span> en ressources</h1>
            <p class="lead mt-3">Trouvez le point de collecte le plus proche et contribuez à un environnement plus propre.</p>
            <button class="btn btn-success btn-lg mt-4">Trouver un point de collecte</button>
        </div>
    </header>

    <!-- Contenu principal -->
    <main>
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
                            <div class="collection-card card">
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
    </main>

    <!-- Pied de page -->
    <footer>
        <div class="container">
            <p class="mb-0">&copy; 2023 Waste2Product. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Script pour la navbar qui change au scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>