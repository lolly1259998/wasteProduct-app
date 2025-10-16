@extends('back.layout')

@section('title', 'Modifier le Processus de Recyclage')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('recyclingprocesses.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left me-2"></i> Retour
                </a>
                <div>
                    <h1 class="page-title text-success mb-1">
                        <i class="bi bi-pencil-square me-2"></i> Modifier le Processus de Recyclage
                    </h1>
                    <p class="text-muted mb-0">Mettre à jour les informations du processus #{{ $recyclingProcess->id }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i> Informations du Processus</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('recyclingprocesses.update', $recyclingProcess->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Déchet -->
                        <div class="mb-4">
                            <label for="waste_id" class="form-label fw-medium">
                                <i class="bi bi-trash me-2 text-success"></i>Déchet à recycler <span class="text-danger">*</span>
                            </label>
                            <select name="waste_id" id="waste_id" 
                                    class="form-select @error('waste_id') is-invalid @enderror" 
                                    required>
                                <option value="">-- Sélectionnez un déchet --</option>
                                @foreach($wastes as $waste)
                                    <option value="{{ $waste->id }}" 
                                        {{ old('waste_id', $recyclingProcess->waste_id) == $waste->id ? 'selected' : '' }}>
                                        {{ $waste->type }} - {{ $waste->category->name ?? 'Sans catégorie' }} ({{ $waste->weight }} kg)
                                    </option>
                                @endforeach
                            </select>
                            @error('waste_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Méthode -->
                        <div class="mb-4">
                            <label for="method" class="form-label fw-medium">
                                <i class="bi bi-gear me-2 text-success"></i>Méthode de recyclage <span class="text-danger">*</span>
                            </label>
                            <select name="method" id="method" 
                                    class="form-select @error('method') is-invalid @enderror" 
                                    required>
                                <option value="">-- Sélectionnez une méthode --</option>
                                <option value="Compostage" {{ old('method', $recyclingProcess->method) == 'Compostage' ? 'selected' : '' }}>Compostage</option>
                                <option value="Recyclage mécanique" {{ old('method', $recyclingProcess->method) == 'Recyclage mécanique' ? 'selected' : '' }}>Recyclage mécanique</option>
                                <option value="Recyclage chimique" {{ old('method', $recyclingProcess->method) == 'Recyclage chimique' ? 'selected' : '' }}>Recyclage chimique</option>
                                <option value="Incinération avec récupération d'énergie" {{ old('method', $recyclingProcess->method) == 'Incinération avec récupération d\'énergie' ? 'selected' : '' }}>Incinération avec récupération d'énergie</option>
                                <option value="Réemploi" {{ old('method', $recyclingProcess->method) == 'Réemploi' ? 'selected' : '' }}>Réemploi</option>
                                <option value="Autre" {{ old('method', $recyclingProcess->method) == 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="mb-4">
                            <label for="status" class="form-label fw-medium">
                                <i class="bi bi-flag me-2 text-success"></i>Statut <span class="text-danger">*</span>
                            </label>
                            <select name="status" id="status" 
                                    class="form-select @error('status') is-invalid @enderror" 
                                    required>
                                <option value="pending" {{ old('status', $recyclingProcess->status) == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="in_progress" {{ old('status', $recyclingProcess->status) == 'in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="completed" {{ old('status', $recyclingProcess->status) == 'completed' ? 'selected' : '' }}>Complété</option>
                                <option value="failed" {{ old('status', $recyclingProcess->status) == 'failed' ? 'selected' : '' }}>Échoué</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Date début -->
                            <div class="col-md-6 mb-4">
                                <label for="start_date" class="form-label fw-medium">
                                    <i class="bi bi-calendar me-2 text-success"></i>Date de début <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       name="start_date" 
                                       id="start_date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       value="{{ old('start_date', $recyclingProcess->start_date ? $recyclingProcess->start_date->format('Y-m-d') : '') }}" 
                                       required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date fin -->
                            <div class="col-md-6 mb-4">
                                <label for="end_date" class="form-label fw-medium">
                                    <i class="bi bi-calendar-check me-2 text-success"></i>Date de fin (optionnel)
                                </label>
                                <input type="date" 
                                       name="end_date" 
                                       id="end_date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       value="{{ old('end_date', $recyclingProcess->end_date ? $recyclingProcess->end_date->format('Y-m-d') : '') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Quantité sortie -->
                            <div class="col-md-6 mb-4">
                                <label for="output_quantity" class="form-label fw-medium">
                                    <i class="bi bi-box me-2 text-success"></i>Quantité en sortie (kg)
                                </label>
                                <input type="number" 
                                       name="output_quantity" 
                                       id="output_quantity" 
                                       class="form-control @error('output_quantity') is-invalid @enderror" 
                                       value="{{ old('output_quantity', $recyclingProcess->output_quantity) }}" 
                                       step="0.01" 
                                       min="0"
                                       placeholder="Ex: 50.5">
                                @error('output_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Qualité sortie -->
                            <div class="col-md-6 mb-4">
                                <label for="output_quality" class="form-label fw-medium">
                                    <i class="bi bi-star me-2 text-success"></i>Qualité en sortie
                                </label>
                                <select name="output_quality" id="output_quality" class="form-select @error('output_quality') is-invalid @enderror">
                                    <option value="">-- Sélectionnez --</option>
                                    <option value="Excellent" {{ old('output_quality', $recyclingProcess->output_quality) == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                                    <option value="Bon" {{ old('output_quality', $recyclingProcess->output_quality) == 'Bon' ? 'selected' : '' }}>Bon</option>
                                    <option value="Moyen" {{ old('output_quality', $recyclingProcess->output_quality) == 'Moyen' ? 'selected' : '' }}>Moyen</option>
                                    <option value="Faible" {{ old('output_quality', $recyclingProcess->output_quality) == 'Faible' ? 'selected' : '' }}>Faible</option>
                                </select>
                                @error('output_quality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Utilisateur responsable -->
                        <div class="mb-4">
                            <label for="responsible_user_id" class="form-label fw-medium">
                                <i class="bi bi-person me-2 text-success"></i>Responsable du processus
                            </label>
                            <select name="responsible_user_id" id="responsible_user_id" class="form-select @error('responsible_user_id') is-invalid @enderror">
                                <option value="">-- Non assigné --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" 
                                        {{ old('responsible_user_id', $recyclingProcess->responsible_user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('responsible_user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-medium">
                                <i class="bi bi-journal-text me-2 text-success"></i>Notes additionnelles
                            </label>
                            <textarea name="notes" 
                                      id="notes" 
                                      class="form-control @error('notes') is-invalid @enderror" 
                                      rows="4" 
                                      placeholder="Ajoutez des remarques ou informations supplémentaires...">{{ old('notes', $recyclingProcess->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('recyclingprocesses.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-x-circle me-2"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-warning px-4">
                                <i class="bi bi-check-circle me-2"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-title { font-weight: 600; font-size: 1.75rem; }
.form-label { color: #495057; }
.form-control:focus, .form-select:focus { border-color: #198754; box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25); }
</style>
@endsection

