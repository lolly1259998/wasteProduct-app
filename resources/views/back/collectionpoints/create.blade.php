@extends('back.layout')

@section('title', 'Ajouter un Point de Collecte')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xxl-10 col-xl-12 col-lg-12">
            <!-- En-tête de page -->
            <div class="page-header mb-5">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="page-pretitle">Gestion des points</div>
                        <h1 class="page-title">
                            <i class="bi bi-pin-map-fill me-3 text-success"></i>
                            Ajouter un Point de Collecte
                        </h1>
                        <p class="text-muted mb-0">Créez un nouveau point de collecte pour votre réseau de recyclage</p>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('collectionpoints.index') }}" class="btn btn-outline-success btn-icon">
                            <i class="bi bi-arrow-left me-2"></i>
                            Retour à la liste
                        </a>
                    </div>
                </div>
            </div>

            <!-- Carte principale du formulaire -->
            <div class="card shadow-lg border-0 rounded-2">
                <div class="card-header bg-gradient-success text-white py-4 px-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-semibold">
                                <i class="bi bi-plus-circle-fill me-3"></i>
                                Nouveau Point de Collecte
                            </h4>
                            <p class="mb-0 opacity-75">Remplissez les informations ci-dessous</p>
                        </div>
                        <div class="badge bg-white bg-opacity-20 text-white fs-6 px-3 py-2">
                            <i class="bi bi-stars me-1"></i>Nouveau
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-2 border-0 shadow-sm mb-5" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="alert-icon">
                                    <i class="bi bi-shield-exclamation fs-3"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="alert-heading mb-2 fw-semibold">Erreurs de validation</h6>
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li class="small">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('collectionpoints.store') }}" method="POST" id="collectionPointForm" class="needs-validation" novalidate>
                        @csrf

                        <!-- Navigation par étapes -->
                        <div class="form-steps mb-5">
                            <div class="steps-progress">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%;"></div>
                                </div>
                                <div class="steps">
                                    <div class="step active" data-step="1">
                                        <div class="step-icon">1</div>
                                        <span class="step-label">Informations</span>
                                    </div>
                                    <div class="step" data-step="2">
                                        <div class="step-icon">2</div>
                                        <span class="step-label">Localisation</span>
                                    </div>
                                    <div class="step" data-step="3">
                                        <div class="step-icon">3</div>
                                        <span class="step-label">Configuration</span>
                                    </div>
                                    <div class="step" data-step="4">
                                        <div class="step-icon">4</div>
                                        <span class="step-label">Validation</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 1: Informations de base -->
                        <div class="form-step active" data-step="1">
                            <div class="section-header mb-4">
                                <div class="section-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div>
                                    <h5 class="section-title mb-1">Informations de base</h5>
                                    <p class="section-subtitle text-muted mb-0">Informations principales du point de collecte</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control form-control-lg" 
                                               id="name" value="{{ old('name') }}" 
                                               placeholder="Nom du point de collecte" required>
                                        <label for="name">
                                            <i class="bi bi-building me-2 text-success"></i>
                                            Nom du point <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="bi bi-info-circle me-1 text-success"></i>Nom officiel du point de collecte
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="city" class="form-control form-control-lg" 
                                               id="city" value="{{ old('city') }}" 
                                               placeholder="Ville" required>
                                        <label for="city">
                                            <i class="bi bi-geo-alt me-2 text-success"></i>
                                            Ville <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" name="address" class="form-control form-control-lg" 
                                               id="address" value="{{ old('address') }}" 
                                               placeholder="Adresse complète" required>
                                        <label for="address">
                                            <i class="bi bi-house-door me-2 text-success"></i>
                                            Adresse complète <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 2: Localisation -->
                        <div class="form-step" data-step="2">
                            <div class="section-header mb-4">
                                <div class="section-icon">
                                    <i class="bi bi-geo-fill"></i>
                                </div>
                                <div>
                                    <h5 class="section-title mb-1">Coordonnées géographiques</h5>
                                    <p class="section-subtitle text-muted mb-0">Localisation précise du point</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" name="postal_code" class="form-control" 
                                               id="postal_code" value="{{ old('postal_code') }}" 
                                               placeholder="Code postal">
                                        <label for="postal_code">
                                            <i class="bi bi-mailbox me-2 text-success"></i>
                                            Code postal
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" step="any" name="latitude" class="form-control" 
                                               id="latitude" value="{{ old('latitude') }}" 
                                               placeholder="Latitude">
                                        <label for="latitude">
                                            <i class="bi bi-globe-americas me-2 text-success"></i>
                                            Latitude
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" step="any" name="longitude" class="form-control" 
                                               id="longitude" value="{{ old('longitude') }}" 
                                               placeholder="Longitude">
                                        <label for="longitude">
                                            <i class="bi bi-globe me-2 text-success"></i>
                                            Longitude
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-success mt-4 rounded-2 border-0">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-geo-alt-fill fs-4 me-3 text-success"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">Localisation sur carte</h6>
                                        <p class="mb-0 small">Les coordonnées géographiques sont optionnelles mais recommandées pour l'affichage sur carte interactive.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 3: Configuration -->
                        <div class="form-step" data-step="3">
                            <div class="section-header mb-4">
                                <div class="section-icon">
                                    <i class="bi bi-gear-fill"></i>
                                </div>
                                <div>
                                    <h5 class="section-title mb-1">Configuration</h5>
                                    <p class="section-subtitle text-muted mb-0">Paramètres et horaires</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="contact_phone" class="form-control" 
                                               id="contact_phone" value="{{ old('contact_phone') }}" 
                                               placeholder="Téléphone">
                                        <label for="contact_phone">
                                            <i class="bi bi-telephone-fill me-2 text-success"></i>
                                            Téléphone
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="status" class="form-select" id="status" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>🟢 Actif</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>🔴 Inactif</option>
                                        </select>
                                        <label for="status">
                                            <i class="bi bi-toggle-on me-2 text-success"></i>
                                            Statut <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold mb-3">
                                        <i class="bi bi-clock me-2 text-success"></i>
                                        Horaires d'ouverture
                                        <span class="badge bg-success bg-opacity-20 text-success ms-2">JSON</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <textarea name="opening_hours" class="form-control json-editor" 
                                                  rows="6" placeholder='{"lundi": "9h-18h", "mardi": "9h-18h", ...}'
                                                  data-bs-toggle="tooltip" title="Format JSON pour les horaires">{{ old('opening_hours') }}</textarea>
                                        <button type="button" class="btn btn-success json-format-btn">
                                            <i class="bi bi-code-slash"></i>
                                        </button>
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="bi bi-lightbulb me-1 text-success"></i>Format JSON recommandé pour une structure flexible
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold mb-3">
                                        <i class="bi bi-folder me-2 text-success"></i>
                                        Catégories acceptées
                                        <span class="badge bg-success bg-opacity-20 text-success ms-2">JSON</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <textarea name="accepted_categories" class="form-control json-editor" 
                                                  rows="6" placeholder='["verre", "papier", "plastique", "métal"]'
                                                  data-bs-toggle="tooltip" title="Format JSON pour les catégories">{{ old('accepted_categories') }}</textarea>
                                        <button type="button" class="btn btn-success json-format-btn">
                                            <i class="bi bi-code-slash"></i>
                                        </button>
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="bi bi-lightbulb me-1 text-success"></i>Liste des catégories de déchets acceptées
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning mt-4 rounded-2 border-0">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-magic fs-4 me-3 text-warning"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">Astuce de formatage</h6>
                                        <p class="mb-0 small">Utilisez le bouton <i class="bi bi-code-slash text-success"></i> pour valider et formater automatiquement votre JSON.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 4: Validation -->
                        <div class="form-step" data-step="4">
                            <div class="section-header mb-4">
                                <div class="section-icon">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div>
                                    <h5 class="section-title mb-1">Validation</h5>
                                    <p class="section-subtitle text-muted mb-0">Vérifiez les informations saisies</p>
                                </div>
                            </div>

                            <div class="review-card bg-light rounded-3 p-4 mb-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <strong class="text-success">Nom:</strong> <span id="review-name" class="text-dark">-</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong class="text-success">Ville:</strong> <span id="review-city" class="text-dark">-</span>
                                    </div>
                                    <div class="col-12">
                                        <strong class="text-success">Adresse:</strong> <span id="review-address" class="text-dark">-</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong class="text-success">Statut:</strong> <span id="review-status" class="text-dark">-</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong class="text-success">Téléphone:</strong> <span id="review-phone" class="text-dark">-</span>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-success rounded-2 border-0">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-check fs-4 me-3 text-success"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">Prêt à créer !</h6>
                                        <p class="mb-0 small">Vérifiez que toutes les informations sont correctes avant de créer le point de collecte.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation entre les étapes -->
                        <div class="form-navigation mt-5 pt-4 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-outline-success btn-prev" disabled>
                                    <i class="bi bi-chevron-left me-2"></i>Précédent
                                </button>
                                
                                <div class="step-indicator">
                                    <span class="current-step">1</span> sur <span class="total-steps">4</span>
                                </div>
                                
                                <div>
                                    <button type="button" class="btn btn-success btn-next">
                                        Suivant <i class="bi bi-chevron-right ms-2"></i>
                                    </button>
                                    <button type="submit" class="btn btn-success btn-submit">
                                        <i class="bi bi-plus-circle me-2"></i>Créer le point
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-header {
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 1.5rem;
    }
    
    .page-pretitle {
        color: #6c757d;
        text-transform: uppercase;
        font-size: 0.875rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .page-title {
        color: #2c3e50;
        font-weight: 700;
        font-size: 2rem;
    }
    
    .card {
        border: none;
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        overflow: hidden;
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #198754 0%, #157347 100%);
    }
    
    /* Steps Navigation */
    .form-steps {
        position: relative;
    }
    
    .steps-progress {
        position: relative;
    }
    
    .steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-top: -12px;
    }
    
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    
    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-bottom: 8px;
        transition: all 0.3s ease;
        border: 3px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .step.active .step-icon {
        background: #198754;
        color: white;
        transform: scale(1.1);
    }
    
    .step-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6c757d;
    }
    
    .step.active .step-label {
        color: #198754;
        font-weight: 600;
    }
    
    /* Form Sections */
    .form-step {
        display: none;
        animation: fadeIn 0.5s ease-in;
    }
    
    .form-step.active {
        display: block;
    }
    
    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 0;
    }
    
    .section-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #198754, #157347);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }
    
    .section-title {
        color: #2c3e50;
        font-weight: 600;
        margin: 0;
    }
    
    .section-subtitle {
        font-size: 0.9rem;
    }
    
    /* Form Elements */
    .form-floating {
        position: relative;
    }
    
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem 0.75rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
    }
    
    .form-control-lg {
        font-size: 1.1rem;
    }
    
    .json-editor {
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        border-radius: 8px;
        resize: vertical;
    }
    
    .json-format-btn {
        border-radius: 0 8px 8px 0;
    }
    
    /* Buttons */
    .btn {
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-icon {
        display: inline-flex;
        align-items: center;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #198754, #157347);
        border: none;
    }
    
    .btn-outline-success {
        border-color: #198754;
        color: #198754;
    }
    
    .btn-outline-success:hover {
        background: #198754;
        color: white;
    }
    
    .btn-submit {
        display: none;
        background: linear-gradient(135deg, #198754, #157347);
        border: none;
    }
    
    /* Alerts */
    .alert {
        border: none;
        border-radius: 12px;
        border-left: 4px solid;
    }
    
    .alert-success {
        border-left-color: #198754;
        background: rgba(25, 135, 84, 0.1);
    }
    
    .alert-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    /* Review Card */
    .review-card {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    /* Step Indicator */
    .step-indicator {
        background: #f8f9fa;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        color: #6c757d;
    }
    
    /* Badges */
    .badge.bg-success {
        background: rgba(25, 135, 84, 0.2) !important;
        color: #198754;
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }
        
        .section-header {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
        
        .form-navigation {
            flex-direction: column;
            gap: 1rem;
        }
        
        .form-navigation > div {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation des tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Gestion des étapes du formulaire
        const steps = document.querySelectorAll('.form-step');
        const stepButtons = {
            prev: document.querySelector('.btn-prev'),
            next: document.querySelector('.btn-next'),
            submit: document.querySelector('.btn-submit')
        };
        const stepIndicator = document.querySelector('.current-step');
        const progressBar = document.querySelector('.progress-bar');
        let currentStep = 1;
        
        // Afficher l'étape actuelle
        function showStep(step) {
            steps.forEach(s => s.classList.remove('active'));
            document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');
            
            // Mettre à jour la navigation
            stepButtons.prev.disabled = step === 1;
            stepButtons.next.style.display = step === steps.length ? 'none' : 'inline-block';
            stepButtons.submit.style.display = step === steps.length ? 'inline-block' : 'none';
            
            // Mettre à jour l'indicateur
            stepIndicator.textContent = step;
            
            // Mettre à jour la barre de progression
            const progress = ((step - 1) / (steps.length - 1)) * 100;
            progressBar.style.width = `${progress}%`;
            
            // Mettre à jour les étapes visuelles
            document.querySelectorAll('.step').forEach((s, index) => {
                if (index + 1 <= step) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
            
            // Mettre à jour la revue à l'étape 4
            if (step === 4) {
                updateReview();
            }
        }
        
        // Navigation suivante
        stepButtons.next.addEventListener('click', function() {
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            }
        });
        
        // Navigation précédente
        stepButtons.prev.addEventListener('click', function() {
            currentStep--;
            showStep(currentStep);
        });
        
        // Validation des étapes
        function validateStep(step) {
            const currentStepEl = document.querySelector(`.form-step[data-step="${step}"]`);
            const inputs = currentStepEl.querySelectorAll('[required]');
            let valid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.classList.add('is-invalid');
                    
                    // Animation de shake
                    input.style.animation = 'shake 0.5s ease-in-out';
                    setTimeout(() => {
                        input.style.animation = '';
                    }, 500);
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (!valid) {
                showToast('Veuillez remplir tous les champs obligatoires', 'warning');
            }
            
            return valid;
        }
        
        // Formatage JSON
        document.querySelectorAll('.json-format-btn').forEach(button => {
            button.addEventListener('click', function() {
                const inputGroup = this.closest('.input-group');
                const textarea = inputGroup.querySelector('textarea');
                
                try {
                    if (textarea.value.trim()) {
                        const jsonObj = JSON.parse(textarea.value);
                        textarea.value = JSON.stringify(jsonObj, null, 2);
                        showToast('JSON formaté avec succès', 'success');
                    }
                } catch(e) {
                    showToast('JSON invalide: ' + e.message, 'error');
                }
            });
        });
        
        // Mise à jour de la revue
        function updateReview() {
            document.getElementById('review-name').textContent = document.getElementById('name').value || '-';
            document.getElementById('review-city').textContent = document.getElementById('city').value || '-';
            document.getElementById('review-address').textContent = document.getElementById('address').value || '-';
            document.getElementById('review-status').textContent = 
                document.getElementById('status').options[document.getElementById('status').selectedIndex].text;
            document.getElementById('review-phone').textContent = document.getElementById('contact_phone').value || '-';
        }
        
        // Toast notifications
        function showToast(message, type = 'info') {
            // Implémentation simplifiée des toasts
            alert(message); // À remplacer par un vrai système de toasts
        }
        
        // Validation finale du formulaire
        document.getElementById('collectionPointForm').addEventListener('submit', function(e) {
            if (!validateStep(currentStep)) {
                e.preventDefault();
                showToast('Veuillez corriger les erreurs avant de soumettre', 'error');
            }
        });
        
        // Initialisation
        showStep(currentStep);
        
        // Animation de shake pour les erreurs
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
            .is-invalid {
                border-color: #dc3545 !important;
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endsection