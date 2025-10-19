@extends('back.layout')

@section('title', 'Démonstration IA - Module Recyclage')

@section('content')
<!-- Token CSRF pour les requêtes AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid px-0">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-4">
                <div>
                    <h1 class="page-title text-success mb-1">
                        <i class="bi bi-robot me-2"></i> Démonstration IA - Module Recyclage
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Statut du service IA -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1">
                                <i class="bi bi-server me-2"></i> Service IA
                            </h5>
                            <p class="text-muted mb-0">État du service d'intelligence artificielle</p>
                        </div>
                        <div>
                            <span id="ai-status" class="badge bg-secondary">Vérification...</span>
                            <button class="btn btn-outline-primary btn-sm ms-2" onclick="checkAIStatus()">
                                <i class="bi bi-arrow-clockwise"></i> Actualiser
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 1. Classification de Déchets -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-search me-2"></i> Classification de Déchets
                    </h5>
                </div>
                <div class="card-body">
                    <form id="classify-form">
                        <div class="mb-3">
                            <label class="form-label">Type de déchet</label>
                            <input type="text" class="form-control" name="type" placeholder="Ex: bouteille plastique" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Poids (kg)</label>
                            <input type="number" class="form-control" name="weight" step="0.1" placeholder="Ex: 0.5" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Description détaillée du déchet..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-robot me-2"></i> Classifier avec l'IA
                        </button>
                    </form>
                    
                    <div id="classify-result" class="mt-3" style="display: none;">
                        <div class="alert alert-info">
                            <h6>Résultat de la classification :</h6>
                            <div id="classify-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Prédiction de Qualité -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-star me-2"></i> Prédiction de Qualité
                    </h5>
                </div>
                <div class="card-body">
                    <form id="quality-form">
                        <div class="mb-3">
                            <label class="form-label">Type de déchet</label>
                            <select class="form-select" name="waste_type" required>
                                <option value="">Sélectionnez...</option>
                                <option value="Plastique">Plastique</option>
                                <option value="Verre">Verre</option>
                                <option value="Papier">Papier</option>
                                <option value="Métal">Métal</option>
                                <option value="Organique">Organique</option>
                                <option value="Électronique">Électronique</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Méthode de recyclage</label>
                            <select class="form-select" name="recycling_method" required>
                                <option value="">Sélectionnez...</option>
                                <option value="Recyclage mécanique">Recyclage mécanique</option>
                                <option value="Fusion et moulage">Fusion et moulage</option>
                                <option value="Pulpage et reformage">Pulpage et reformage</option>
                                <option value="Compostage">Compostage</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">État du déchet</label>
                            <select class="form-select" name="waste_condition" required>
                                <option value="excellent">Excellent</option>
                                <option value="good" selected>Bon</option>
                                <option value="fair">Moyen</option>
                                <option value="poor">Mauvais</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jours de stockage</label>
                            <input type="number" class="form-control" name="storage_days" value="0" min="0">
                        </div>
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-graph-up me-2"></i> Prédire la Qualité
                        </button>
                    </form>
                    
                    <div id="quality-result" class="mt-3" style="display: none;">
                        <div class="alert alert-warning">
                            <h6>Prédiction de qualité :</h6>
                            <div id="quality-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Estimation de Prix -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-currency-dollar me-2"></i> Estimation de Prix
                    </h5>
                </div>
                <div class="card-body">
                    <form id="price-form">
                        <div class="mb-3">
                            <label class="form-label">Nom du produit</label>
                            <input type="text" class="form-control" name="product_name" placeholder="Ex: Sac à dos recyclé" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catégorie de déchet</label>
                            <select class="form-select" name="waste_category" required>
                                <option value="">Sélectionnez...</option>
                                <option value="Plastique">Plastique</option>
                                <option value="Verre">Verre</option>
                                <option value="Papier">Papier</option>
                                <option value="Métal">Métal</option>
                                <option value="Organique">Organique</option>
                                <option value="Électronique">Électronique</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Score de qualité (0-100)</label>
                            <input type="number" class="form-control" name="quality_score" value="70" min="0" max="100">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Coût de recyclage (DT)</label>
                            <input type="number" class="form-control" name="recycling_cost" value="10" step="0.1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Demande du marché (0-100)</label>
                            <input type="number" class="form-control" name="market_demand" value="50" min="0" max="100">
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-calculator me-2"></i> Estimer le Prix
                        </button>
                    </form>
                    
                    <div id="price-result" class="mt-3" style="display: none;">
                        <div class="alert alert-success">
                            <h6>Estimation de prix :</h6>
                            <div id="price-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Génération de Description -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i> Génération de Description
                    </h5>
                </div>
                <div class="card-body">
                    <form id="description-form">
                        <div class="mb-3">
                            <label class="form-label">Nom du produit</label>
                            <input type="text" class="form-control" name="product_name" placeholder="Ex: Sac à dos écologique" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Matériau source</label>
                            <input type="text" class="form-control" name="source_material" placeholder="Ex: Bouteilles plastiques" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Méthode de recyclage</label>
                            <input type="text" class="form-control" name="recycling_method" placeholder="Ex: Recyclage mécanique" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Spécifications (JSON)</label>
                            <textarea class="form-control" name="specifications" rows="3" placeholder='{"dimensions": "30x40cm", "poids": "500g"}'></textarea>
                        </div>
                        <button type="submit" class="btn btn-info w-100">
                            <i class="bi bi-magic me-2"></i> Générer Description
                        </button>
                    </form>
                    
                    <div id="description-result" class="mt-3" style="display: none;">
                        <div class="alert alert-info">
                            <h6>Description générée :</h6>
                            <div id="description-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Vérifier l'état du service IA au chargement
document.addEventListener('DOMContentLoaded', function() {
    checkAIStatus();
});

// Vérifier l'état du service IA
function checkAIStatus() {
    fetch('/ai/recycling/health')
        .then(response => response.json())
        .then(data => {
            const statusElement = document.getElementById('ai-status');
            if (data.status === 'healthy') {
                statusElement.className = 'badge bg-success';
                statusElement.textContent = 'Service IA actif';
            } else {
                statusElement.className = 'badge bg-danger';
                statusElement.textContent = 'Service IA indisponible';
            }
        })
        .catch(error => {
            const statusElement = document.getElementById('ai-status');
            statusElement.className = 'badge bg-danger';
            statusElement.textContent = 'Service IA indisponible';
        });
}

// Classification de déchets
document.getElementById('classify-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    console.log('Form submitted!'); // Debug
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    console.log('Data to send:', data); // Debug
    
    fetch('/ai/recycling/classify-waste', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('Response status:', response.status); // Debug
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data); // Debug
        if (data.success) {
            const result = data.classification;
            document.getElementById('classify-content').innerHTML = `
                <strong>Catégorie:</strong> ${result.category}<br>
                <strong>Confiance:</strong> ${(result.confidence * 100).toFixed(1)}%<br>
                <strong>Méthode recommandée:</strong> ${result.recommended_method}<br>
                <strong>Score de recyclabilité:</strong> ${result.recyclability_score}%
            `;
            document.getElementById('classify-result').style.display = 'block';
        } else {
            alert('Erreur: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error); // Debug
        alert('Erreur de connexion au service IA: ' + error.message);
    });
});

// Prédiction de qualité
document.getElementById('quality-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('/ai/recycling/predict-quality', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const result = data.quality_prediction;
            document.getElementById('quality-content').innerHTML = `
                <strong>Score:</strong> ${result.score}%<br>
                <strong>Niveau:</strong> <span class="badge bg-${result.color}">${result.level}</span><br>
                <strong>Recommandations:</strong><br>
                <ul>${result.recommendations.map(rec => `<li>${rec}</li>`).join('')}</ul>
            `;
            document.getElementById('quality-result').style.display = 'block';
        } else {
            alert('Erreur: ' + data.error);
        }
    })
    .catch(error => {
        alert('Erreur de connexion au service IA');
    });
});

// Estimation de prix
document.getElementById('price-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('/ai/recycling/estimate-price', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const result = data.price_estimation;
            document.getElementById('price-content').innerHTML = `
                <strong>Prix de base:</strong> ${result.base_price} DT<br>
                <strong>Prix estimé:</strong> ${result.estimated_price} DT<br>
                <strong>Prix final (avec marge):</strong> <span class="fw-bold text-success">${result.final_price} DT</span><br>
                <strong>Marge de profit:</strong> ${result.profit_margin} DT<br>
                <strong>Confiance:</strong> ${(result.confidence * 100).toFixed(1)}%
            `;
            document.getElementById('price-result').style.display = 'block';
        } else {
            alert('Erreur: ' + data.error);
        }
    })
    .catch(error => {
        alert('Erreur de connexion au service IA');
    });
});

// Génération de description
document.getElementById('description-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Parser les spécifications JSON
    if (data.specifications) {
        try {
            data.specifications = JSON.parse(data.specifications);
        } catch (e) {
            data.specifications = {};
        }
    }
    
    fetch('/ai/recycling/generate-description', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('description-content').innerHTML = `
                <div class="p-3 bg-light rounded">
                    ${data.description}
                </div>
            `;
            document.getElementById('description-result').style.display = 'block';
        } else {
            alert('Erreur: ' + data.error);
        }
    })
    .catch(error => {
        alert('Erreur de connexion au service IA');
    });
});
</script>
@endsection
