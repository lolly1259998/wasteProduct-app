<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Point de Collecte - Économie Circulaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root {
            --primary-color: #2e7d32;
            --primary-light: #4caf50;
            --primary-dark: #1b5e20;
            --accent-color: #ff9800;
            --text-dark: #333;
            --text-light: #666;
            --background-light: #f8f9fa;
            --card-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            --card-hover-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            color: var(--text-dark);
            min-height: 100vh;
        }
        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            padding: 3rem 0;
            border-radius: 0 0 30px 30px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .page-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }
        .page-subtitle {
            opacity: 0.9;
            font-size: 1.1rem;
        }
        .detail-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            background: white;
            margin-bottom: 2rem;
        }
        .card-header-custom {
            background: linear-gradient(to right, var(--primary-color), var(--primary-light));
            color: white;
            padding: 1.5rem;
            border-bottom: none;
        }
        .card-title {
            font-weight: 700;
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }
        .info-section { padding: 1.5rem; }
        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .info-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .info-icon {
            background-color: rgba(46, 125, 50, 0.1);
            color: var(--primary-color);
            width: 40px; height: 40px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin-right: 1rem; flex-shrink: 0;
        }
        .info-content { flex: 1; }
        .info-label { font-weight: 600; color: var(--text-dark); margin-bottom: 0.3rem; }
        .info-value { color: var(--text-light); }
        .badge-custom {
            padding: 0.5rem 0.8rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        .category-badge {
            display: inline-block;
            background-color: rgba(46, 125, 50, 0.1);
            color: var(--primary-dark);
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            margin: 0.2rem;
            font-size: 0.85rem;
        }
        .hours-list { list-style: none; padding-left: 0; margin-bottom: 0; }
        .hours-list li { padding: 0.3rem 0; border-bottom: 1px solid #f5f5f5; }
        .hours-list li:last-child { border-bottom: none; }
        .map-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            margin-top: 1rem;
        }
        #map { height: 300px; width: 100%; }
        .btn-success {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        .btn-outline-secondary {
            border-radius: 50px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .last-updated {
            background-color: rgba(0, 0, 0, 0.03);
            border-radius: 10px;
            padding: 0.8rem;
            text-align: center;
            margin-top: 1.5rem;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f0f0f0;
        }
        @media (max-width: 768px) {
            .action-buttons { flex-direction: column; gap: 1rem; }
            .action-buttons a { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container text-center">
            <h1 class="page-title animate__animated animate__fadeIn">
                <i class="bi bi-recycle me-2"></i> Détails du Point de Collecte
            </h1>
            <p class="page-subtitle animate__animated animate__fadeIn animate__delay-1s">
                Informations complètes sur ce point de collecte
            </p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="detail-card animate__animated animate__zoomIn">
            <div class="card-header-custom">
                <h3 class="card-title">
                    <i class="bi bi-geo-alt-fill me-2"></i> {{ $collectionPoint->name }}
                </h3>
            </div>
            <div class="info-section">

                <div class="info-item">
                    <div class="info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div class="info-content">
                        <div class="info-label">Adresse</div>
                        <div class="info-value">{{ $collectionPoint->address }}, {{ $collectionPoint->city }} {{ $collectionPoint->postal_code }}</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div class="info-content">
                        <div class="info-label">Téléphone</div>
                        <div class="info-value">
                            @if ($collectionPoint->contact_phone)
                                <a href="tel:{{ $collectionPoint->contact_phone }}">{{ $collectionPoint->contact_phone }}</a>
                            @else
                                <span class="text-muted">Non renseigné</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="bi bi-info-circle-fill"></i></div>
                    <div class="info-content">
                        <div class="info-label">Statut</div>
                        <div class="info-value">
                            @if ($collectionPoint->status === 'actif')
                                <span class="badge-custom bg-success"><i class="bi bi-check-circle me-1"></i> Actif</span>
                            @elseif ($collectionPoint->status === 'inactif')
                                <span class="badge-custom bg-secondary"><i class="bi bi-x-circle me-1"></i> Inactif</span>
                            @else
                                <span class="badge-custom bg-warning text-dark"><i class="bi bi-question-circle me-1"></i> Non défini</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="bi bi-clock-fill"></i></div>
                    <div class="info-content">
                        <div class="info-label">Horaires d'ouverture</div>
                        <div class="info-value">
                            @if (is_array($collectionPoint->opening_hours) && count($collectionPoint->opening_hours) > 0)
                                <ul class="hours-list">
                                    @foreach ($collectionPoint->opening_hours as $hour)
                                        <li>{{ $hour }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">Non renseignés</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="bi bi-tags-fill"></i></div>
                    <div class="info-content">
                        <div class="info-label">Catégories acceptées</div>
                        <div class="info-value">
                            @if (is_array($collectionPoint->accepted_categories) && count($collectionPoint->accepted_categories) > 0)
                                @foreach ($collectionPoint->accepted_categories as $category)
                                    <span class="category-badge">{{ $category }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Aucune catégorie spécifiée</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="bi bi-map-fill"></i></div>
                    <div class="info-content">
                        <div class="info-label">Localisation</div>
                        <div class="info-value">
                            <div class="map-container"><div id="map"></div></div>
                        </div>
                    </div>
                </div>

                <div class="last-updated">
                    <i class="bi bi-arrow-clockwise me-2 text-muted"></i>
                    <small class="text-muted">Dernière mise à jour : {{ $collectionPoint->updated_at->format('d/m/Y à H:i') }}</small>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('front.collectionpoints.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                    </a>
                    @if ($collectionPoint->latitude && $collectionPoint->longitude)
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $collectionPoint->latitude }},{{ $collectionPoint->longitude }}" target="_blank" class="btn btn-success">
                            <i class="bi bi-signpost-split me-1"></i> Obtenir l'itinéraire
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

   <script>
document.addEventListener('DOMContentLoaded', function () {
    @if ($collectionPoint->latitude && $collectionPoint->longitude)
        // ✅ Si latitude/longitude existent
        var lat = {{ $collectionPoint->latitude }};
        var lon = {{ $collectionPoint->longitude }};
        initMap(lat, lon, "{{ $collectionPoint->name }}", "{{ $collectionPoint->address }}", "{{ $collectionPoint->city }} {{ $collectionPoint->postal_code }}");
    @else
        // 🌍 Géocodage en Tunisie uniquement
        var address = "{{ $collectionPoint->address ?? '' }} {{ $collectionPoint->city ?? '' }} {{ $collectionPoint->postal_code ?? '' }} Tunisie";
        var url = `https://nominatim.openstreetmap.org/search?format=json&countrycodes=tn&limit=1&q=${encodeURIComponent(address)}`;

        fetch(url, { headers: { 'User-Agent': 'Waste2Product-App' }})
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    var lat = parseFloat(data[0].lat);
                    var lon = parseFloat(data[0].lon);
                    initMap(lat, lon, "{{ $collectionPoint->name }}", "{{ $collectionPoint->address }}", "{{ $collectionPoint->city }} {{ $collectionPoint->postal_code }}");
                } else {
                    console.warn("Adresse non trouvée en Tunisie. Centrage par défaut sur Tunis.");
                    initMap(36.8065, 10.1815, "Tunis", "Tunisie", "");
                }
            })
            .catch(error => {
                console.error("Erreur de géocodage :", error);
                initMap(36.8065, 10.1815, "Tunis", "Tunisie", "");
            });
    @endif
});

function initMap(lat, lon, name, address, city) {
    var map = L.map('map').setView([lat, lon], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    var greenIcon = L.divIcon({
        html: '<i class="bi bi-geo-alt-fill" style="font-size: 24px; color: #2e7d32;"></i>',
        iconSize: [24, 24],
        className: 'leaflet-div-icon-custom'
    });

    L.marker([lat, lon], { icon: greenIcon })
        .addTo(map)
        .bindPopup(`
            <div class="text-center">
                <h5 class="mb-1">${name}</h5>
                <p class="mb-1">${address}</p>
                <p class="mb-0">${city}</p>
            </div>
        `)
        .openPopup();
}
</script>
</body>
</html>
