@extends('back.layout')

@section('title', 'Modifier le Point de Collecte')

@section('content')
<style>
    :root {
        --primary-green: #198754;
        --light-green: #d1e7dd;
        --dark-green: #0f5132;
        --success-gradient: linear-gradient(135deg, #198754 0%, #20c997 100%);
    }
    
    .card {
        border: none;
        box-shadow: 0 1rem 3rem rgba(25, 135, 84, 0.15);
        border-radius: 20px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    
    .card-header {
        background: var(--success-gradient) !important;
        border-bottom: none;
        padding: 1.5rem 2rem;
    }
    
    .section-title {
        position: relative;
        padding-left: 1rem;
        margin-bottom: 1.5rem;
        font-weight: 700;
        color: var(--dark-green);
    }
    
    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--success-gradient);
        border-radius: 4px;
    }
    
    .info-badge {
        font-size: 0.85rem;
        background: rgba(255, 255, 255, 0.2) !important;
        backdrop-filter: blur(10px);
    }
    
    .current-data-section {
        background: linear-gradient(135deg, #f8fff8 0%, #e8f5e8 100%);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--light-green);
        position: relative;
        overflow: hidden;
    }
    
    .current-data-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--success-gradient);
    }
    
    .data-card {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: white;
        overflow: hidden;
    }
    
    .data-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(25, 135, 84, 0.15);
        border-color: var(--light-green);
    }
    
    .data-card .card-header {
        background: var(--light-green) !important;
        border-bottom: 1px solid #dee2e6;
        padding: 1rem 1.25rem;
    }
    
    .data-card .card-header h6 {
        color: var(--dark-green);
        font-weight: 600;
        margin: 0;
    }
    
    .table-borderless td {
        padding: 0.5rem 0.25rem;
        border: none;
    }
    
    .form-section {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .form-section:hover {
        box-shadow: 0 0.5rem 1rem rgba(25, 135, 84, 0.1);
        border-color: var(--light-green);
    }
    
    .form-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--success-gradient);
        border-radius: 16px 16px 0 0;
    }
    
    .json-field {
        font-family: 'JetBrains Mono', 'Courier New', monospace;
        font-size: 0.85rem;
        border-radius: 12px;
        background: #f8f9fa;
    }
    
    .status-active {
        color: var(--primary-green);
        font-weight: 600;
        background: var(--light-green);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .status-inactive {
        color: #dc3545;
        font-weight: 600;
        background: #f8d7da;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-action {
        min-width: 140px;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-success {
        background: var(--success-gradient);
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(25, 135, 84, 0.3);
    }
    
    .btn-outline-success {
        border: 2px solid var(--primary-green);
        color: var(--primary-green);
    }
    
    .btn-outline-success:hover {
        background: var(--primary-green);
        transform: translateY(-2px);
    }
    
    .form-control, .form-select {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }
    
    .input-group-text {
        background: var(--light-green);
        border: 2px solid #e9ecef;
        border-right: none;
        border-radius: 12px 0 0 12px;
    }
    
    .json-format-btn {
        border-radius: 0 12px 12px 0;
        border: 2px solid #e9ecef;
        border-left: none;
        background: white;
        transition: all 0.3s ease;
    }
    
    .json-format-btn:hover {
        background: var(--light-green);
        color: var(--dark-green);
    }
    
    .alert {
        border-radius: 12px;
        border: none;
        backdrop-filter: blur(10px);
    }
    
    .alert-danger {
        background: rgba(220, 53, 69, 0.1);
        border-left: 4px solid #dc3545;
    }
    
    .floating-label {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .floating-label .form-control {
        padding-top: 1.5rem;
    }
    
    .floating-label label {
        position: absolute;
        top: 0.5rem;
        left: 1rem;
        font-size: 0.8rem;
        color: #6c757d;
        transition: all 0.3s ease;
        pointer-events: none;
    }
    
    .floating-label .form-control:focus + label,
    .floating-label .form-control:not(:placeholder-shown) + label {
        top: 0.25rem;
        font-size: 0.7rem;
        color: var(--primary-green);
    }
    
    .progress-indicator {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 3rem;
        padding: 0 2rem;
    }
    
    .progress-step {
        text-align: center;
        position: relative;
        z-index: 2;
    }
    
    .step-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--light-green);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        color: var(--dark-green);
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }
    
    .step-active .step-icon {
        background: var(--success-gradient);
        color: white;
        box-shadow: 0 0.25rem 0.5rem rgba(25, 135, 84, 0.3);
    }
    
    .step-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--dark-green);
    }
    
    .progress-bar {
        position: absolute;
        top: 25px;
        left: 0;
        right: 0;
        height: 3px;
        background: #e9ecef;
        z-index: 1;
    }
    
    .progress-fill {
        height: 100%;
        background: var(--success-gradient);
        width: 50%;
        transition: width 0.5s ease;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .fade-in {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--light-green);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--dark-green);
        margin-right: 1rem;
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-10">
            <div class="card fade-in">
                <div class="card-header text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-white bg-opacity-20 me-3">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">Modifier le Point de Collecte</h4>
                                <p class="mb-0 opacity-90">Mettez à jour les informations de votre point de collecte</p>
                            </div>
                        </div>
                          
                        <a href="{{ route('collectionpoints.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <!-- Indicateur de progression -->
                    <div class="progress-indicator">
                        <div class="progress-step step-active">
                            <div class="step-icon">
                                <i class="bi bi-eye"></i>
                            </div>
                            <span class="step-label">Consultation</span>
                        </div>
                        <div class="progress-step">
                            <div class="step-icon">
                                <i class="bi bi-pencil"></i>
                            </div>
                            <span class="step-label">Modification</span>
                        </div>
                        <div class="progress-step">
                            <div class="step-icon">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <span class="step-label">Validation</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill"></div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                                <div class="flex-grow-1">
                                    <h6 class="alert-heading mb-2 fw-bold">Données invalides</h6>
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($collectionPoint)
                        <!-- Section d'affichage des données actuelles -->
                        <div class="current-data-section fade-in">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="section-title mb-0">Détails Actuels du Point de Collecte</h4>
                                <span class="badge bg-success info-badge">
                                    <i class="bi bi-clock me-1"></i>Dernière mise à jour: {{ $collectionPoint->updated_at }}
                                </span>
                            </div>
                            
                            <div class="row g-4">
                                    <span class="badge bg-success info-badge">
                                        <i class="bi bi-clock me-1"></i>Dernière mise à jour: {{ $collectionPoint->updated_at }}
                                    </span>
                                </div>
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="data-card h-100">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <i class="bi bi-info-circle me-2"></i>Informations Principales
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-borderless table-sm mb-0">
                                                    <tr>
                                                        <td class="fw-bold text-muted">Nom:</td>
                                                        <td class="fw-semibold">{{ $collectionPoint->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-muted">Adresse:</td>
                                                        <td>{{ $collectionPoint->address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-muted">Ville:</td>
                                                        <td>{{ $collectionPoint->city }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-muted">Code postal:</td>
                                                        <td>{{ $collectionPoint->postal_code }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-muted">Téléphone:</td>
                                                        <td>{{ $collectionPoint->contact_phone }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-muted">Statut:</td>
                                                        <td>
                                                            @if($collectionPoint->status == 'active')
                                                                <span class="status-active">
                                                                    <i class="bi bi-check-circle-fill"></i>Actif
                                                                </span>
                                                            @else
                                                                <span class="status-inactive">
                                                                    <i class="bi bi-x-circle-fill"></i>Inactif
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="data-card h-100">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <i class="bi bi-geo-alt me-2"></i>Coordonnées & Métadonnées
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-borderless table-sm mb-0">
                                                    <tr>
                                                        <td class="fw-bold text-muted">Latitude:</td>
                                                        <td class="font-monospace">{{ $collectionPoint->latitude }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-muted">Longitude:</td>
                                                        <td class="font-monospace">{{ $collectionPoint->longitude }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-muted">Créé le:</td>
                                                        <td>{{ $collectionPoint->created_at }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-muted">Modifié le:</td>
                                                        <td>{{ $collectionPoint->updated_at }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-4 mt-2">
                                    <div class="col-md-6">
                                        <div class="data-card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <i class="bi bi-clock me-2"></i>Horaires d'Ouverture
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <pre class="json-field mb-0 p-3 rounded">{{ $collectionPoint->opening_hours }}</pre>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="data-card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <i class="bi bi-folder-check me-2"></i>Catégories Acceptées
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <pre class="json-field mb-0 p-3 rounded">{{ $collectionPoint->accepted_categories }}</pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Formulaire de modification -->
                            <form action="{{ route('collectionpoints.update', ['collectionpoint' => $collectionPoint->id]) }}" method="POST" id="editForm">
                                @csrf
                                @method('PUT')
                                
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-wrapper">
                                        <i class="bi bi-pencil"></i>
                                    </div>
                                    <div>
                                        <h4 class="section-title mb-1">Modifier les Informations</h4>
                                        <p class="text-muted mb-0">Mettez à jour les détails du point de collecte</p>
                                    </div>
                                </div>
                                
                                <div class="form-section fade-in">
                                    <h5 class="mb-4 text-success">
                                        <i class="bi bi-geo-alt me-2"></i>Informations de Localisation
                                    </h5>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="floating-label">
                                                <input type="text" name="name" id="name" class="form-control" 
                                                       value="{{ old('name', $collectionPoint->name) }}" 
                                                       placeholder=" " required>
                                                <label for="name">Nom du point de collecte *</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="floating-label">
                                                <input type="text" name="city" id="city" class="form-control" 
                                                       value="{{ old('city', $collectionPoint->city) }}" 
                                                       placeholder=" " required>
                                                <label for="city">Ville *</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-8">
                                            <div class="floating-label">
                                                <input type="text" name="address" id="address" class="form-control" 
                                                       value="{{ old('address', $collectionPoint->address) }}" 
                                                       placeholder=" " required>
                                                <label for="address">Adresse complète *</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="floating-label">
                                                <input type="text" name="postal_code" id="postal_code" class="form-control" 
                                                       value="{{ old('postal_code', $collectionPoint->postal_code) }}" 
                                                       placeholder=" ">
                                                <label for="postal_code">Code postal</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-section fade-in">
                                    <h5 class="mb-4 text-success">
                                        <i class="bi bi-telephone me-2"></i>Contact et Statut
                                    </h5>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="floating-label">
                                                <input type="text" name="contact_phone" id="contact_phone" class="form-control" 
                                                       value="{{ old('contact_phone', $collectionPoint->contact_phone) }}" 
                                                       placeholder=" ">
                                                <label for="contact_phone">Numéro de téléphone</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                             <label for="status">Statut du point *</label>
                                            <div class="floating-label">
                                                
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="active" {{ old('status', $collectionPoint->status) == 'active' ? 'selected' : '' }}>🟢 Actif - Point opérationnel</option>
                                                    <option value="inactive" {{ old('status', $collectionPoint->status) == 'inactive' ? 'selected' : '' }}>🔴 Inactif - Point temporairement fermé</option>
                                                </select>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-section fade-in">
                                    <h5 class="mb-4 text-success">
                                        <i class="bi bi-gear me-2"></i>Configuration Avancée
                                    </h5>
                                    
                                    <div class="mb-4">
                                        <label for="opening_hours" class="form-label fw-semibold text-success mb-3">
                                            <i class="bi bi-clock-history me-2"></i>Horaires d'ouverture
                                            <span class="badge bg-success bg-opacity-20 text-success ms-2">JSON</span>
                                        </label>
                                        <div class="input-group">
                                            <textarea name="opening_hours" id="opening_hours" class="form-control json-field" 
                                                      rows="6" placeholder='{"lundi": "9h-18h", "mardi": "9h-18h", ...}'>{{ old('opening_hours', $collectionPoint->opening_hours) }}</textarea>
                                            <button type="button" class="btn json-format-btn" data-bs-toggle="tooltip" title="Formater et valider le JSON">
                                                <i class="bi bi-code-slash"></i>
                                            </button>
                                        </div>
                                     
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="accepted_categories" class="form-label fw-semibold text-success mb-3">
                                            <i class="bi bi-folder-check me-2"></i>Catégories acceptées
                                            <span class="badge bg-success bg-opacity-20 text-success ms-2">JSON</span>
                                        </label>
                                        <div class="input-group">
                                            <textarea name="accepted_categories" id="accepted_categories" class="form-control json-field" 
                                                      rows="6" placeholder='["verre", "papier", "plastique", "métal"]'>{{ old('accepted_categories', $collectionPoint->accepted_categories) }}</textarea>
                                            <button type="button" class="btn json-format-btn" data-bs-toggle="tooltip" title="Formater et valider le JSON">
                                                <i class="bi bi-code-slash"></i>
                                            </button>
                                        </div>
                                      
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-5 pt-4 border-top border-success border-opacity-25">
                                    <a href="{{ route('collectionpoints.index') }}" class="btn btn-outline-success btn-action">
                                        <i class="bi bi-arrow-left me-2"></i> Retour à la liste
                                    </a>
                                    <div class="d-flex gap-3">
                                        <button type="reset" class="btn btn-light btn-action">
                                            <i class="bi bi-arrow-clockwise me-2"></i> Réinitialiser
                                        </button>
                                        <button type="submit" class="btn btn-success btn-action">
                                            <i class="bi bi-check-lg me-2"></i> Enregistrer les modifications
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-danger d-flex align-items-center fade-in">
                                <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                            
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation des tooltips Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            
            // Fonction améliorée pour formater le JSON
            document.querySelectorAll('.json-format-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const inputGroup = this.closest('.input-group');
                    const textarea = inputGroup.querySelector('textarea');
                    
                    try {
                        if (textarea.value.trim()) {
                            const jsonObj = JSON.parse(textarea.value);
                            textarea.value = JSON.stringify(jsonObj, null, 2);
                            
                            // Feedback visuel de succès
                            textarea.classList.add('is-valid');
                            setTimeout(() => {
                                textarea.classList.remove('is-valid');
                            }, 2000);
                            
                            showNotification('JSON formaté avec succès!', 'success');
                        } else {
                            showNotification('Le champ JSON est vide.', 'warning');
                        }
                    } catch(e) {
                        textarea.classList.add('is-invalid');
                        showNotification('Erreur JSON: ' + e.message, 'error');
                    }
                });
            });
            
            // Validation en temps réel des champs requis
            const form = document.getElementById('editForm');
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
                    validateField(this);
                });
                
                field.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        validateField(this);
                    }
                });
            });
            
            function validateField(field) {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    field.classList.remove('is-valid');
                } else {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                }
            }
            
            // Fonction de notification
            function showNotification(message, type) {
                const alertClass = type === 'error' ? 'alert-danger' : 
                                 type === 'warning' ? 'alert-warning' : 'alert-success';
                
                const notification = document.createElement('div');
                notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                notification.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="bi bi-${type === 'error' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-circle' : 'check-circle'}-fill me-2"></i>
                        <span>${message}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 5000);
            }
            
            // Animation au défilement
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            document.querySelectorAll('.fade-in').forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'all 0.6s ease';
                observer.observe(element);
            });
        });
    </script>
</body>
</html>