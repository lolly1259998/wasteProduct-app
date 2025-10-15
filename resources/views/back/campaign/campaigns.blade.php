@extends('back.layout')

@section('content')
<style>
    /* Advanced Campaign Styles */
    .campaign-stats {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .stat-item {
        text-align: center;
        padding: 1rem;
        border-radius: 10px;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease;
    }
    .stat-item:hover {
        transform: translateY(-5px);
    }
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    .stat-label {
        font-size: 1rem;
        opacity: 0.9;
    }

    /* Enhanced Table Styles */
    .campaign-table {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .campaign-table thead {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    .campaign-table tbody tr {
        transition: all 0.3s ease;
    }
    .campaign-table tbody tr:hover {
        background-color: rgba(79, 172, 254, 0.1);
        transform: scale(1.01);
    }
    .badge-custom {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
    }

    /* Enhanced Modal Styles */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    .modal-header {
        border-radius: 20px 20px 0 0;
        border-bottom: none;
        padding: 2rem;
    }
    .modal-body {
        padding: 2rem;
    }
    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 0.75rem;
        transition: border-color 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
    }

    /* Button Enhancements */
    .btn-custom {
        border-radius: 25px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }

    /* Animation for new elements */
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
    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Responsive enhancements */
    @media (max-width: 768px) {
        .campaign-stats {
            padding: 1rem;
        }
        .stat-item {
            margin-bottom: 1rem;
        }
        .modal-dialog {
            margin: 0.5rem;
        }
    }
</style>

<div class="container-fluid py-4 fade-in-up">
    <!-- Campaign Statistics -->
    <div class="campaign-stats">
        <div class="row text-center">
            <div class="col-md-3 mb-3">
                <div class="stat-item">
                    <div class="stat-number" id="total-campaigns">0</div>
                    <div class="stat-label">Total Campagnes</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-item">
                    <div class="stat-number text-success" id="active-campaigns">0</div>
                    <div class="stat-label">Campagnes Actives</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-item">
                    <div class="stat-number text-warning" id="draft-campaigns">0</div>
                    <div class="stat-label">Brouillons</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-item">
                    <div class="stat-number text-secondary" id="closed-campaigns">0</div>
                    <div class="stat-label">Clôturées</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header with Filters -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-megaphone-fill me-2"></i>Gestion des Campagnes
        </h2>
        <div class="d-flex gap-2">
            <select id="status-filter" class="form-select form-select-sm" style="width: auto;">
                <option value="">Tous les statuts</option>
                <option value="active">Actif</option>
                <option value="draft">Brouillon</option>
                <option value="closed">Clôturé</option>
            </select>
            <button class="btn btn-success btn-custom" data-bs-toggle="modal" data-bs-target="#createCampaignModal">
                <i class="bi bi-plus-circle-fill me-2"></i>Nouvelle Campagne
            </button>
        </div>
    </div>

    <!-- Enhanced Campaign Table -->
    <div class="card campaign-table border-0">
        <div class="card-body p-0">
            <table id="campaigns-table" class="table table-hover align-middle w-100 mb-0">
                <thead>
                    <tr class="text-center">
                        <th><i class="bi bi-hash"></i> ID</th>
                        <th><i class="bi bi-tag"></i> Titre</th>
                        <th><i class="bi bi-text-paragraph"></i> Description</th>
                        <th><i class="bi bi-calendar-range"></i> Dates</th>
                        <th><i class="bi bi-flag"></i> Statut</th>
                        <th><i class="bi bi-person"></i> Utilisateur</th>
                        <th><i class="bi bi-gear"></i> Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal pour créer une campagne -->
<div class="modal fade" id="createCampaignModal" tabindex="-1" aria-labelledby="createCampaignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">➕ Créer une Campagne</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="create-campaign-form" class="p-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Titre</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">ID Utilisateur</label>
                            <input type="number" class="form-control" name="user_id">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date de début</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date de fin</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Statut</label>
                            <select class="form-select" name="status" required>
                                <option value="draft">Brouillon</option>
                                <option value="active">Actif</option>
                                <option value="closed">Clôturé</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success px-4">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier une campagne -->
<div class="modal fade" id="editCampaignModal" tabindex="-1" aria-labelledby="editCampaignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title fw-bold">✏️ Modifier la Campagne</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="edit-campaign-form" class="p-3">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Titre</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">ID Utilisateur</label>
                            <input type="number" class="form-control" id="edit_user_id" name="user_id">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date de début</label>
                            <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date de fin</label>
                            <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Statut</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="draft">Brouillon</option>
                                <option value="active">Actif</option>
                                <option value="closed">Clôturé</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-warning px-4 text-white">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    // Initialisation de DataTables avec traduction française
    let table = $('#campaigns-table').DataTable({
        responsive: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        ajax: {
            url: '{{ url("campaigns") }}',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'title', render: function (data) { return `<strong>${data}</strong>`; } },
            { data: 'description', defaultContent: '' },
            { 
                data: null, 
                render: function (data) { return `${data.start_date} → ${data.end_date}`; } 
            },
            { 
                data: 'status',
                render: function (data) {
                    let badgeClass = data === 'active' ? 'success' : (data === 'closed' ? 'secondary' : 'warning');
                    return `<span class="badge bg-${badgeClass}">${data === 'draft' ? 'Brouillon' : data === 'active' ? 'Actif' : 'Clôturé'}</span>`;
                }
            },
            { 
                data: 'user', 
                render: function (data) { return data ? data.name : 'N/A'; } 
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data) {
                    return `
                        <button class="btn btn-sm btn-outline-warning edit-btn" data-id="${data.id}"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${data.id}"><i class="bi bi-trash"></i></button>
                    `;
                }
            }
        ]
    });

    // Update statistics
    function updateStats() {
        $.ajax({
            url: '{{ url("campaigns") }}',
            type: 'GET',
            success: function (data) {
                let total = data.length;
                let active = data.filter(c => c.status === 'active').length;
                let draft = data.filter(c => c.status === 'draft').length;
                let closed = data.filter(c => c.status === 'closed').length;

                $('#total-campaigns').text(total);
                $('#active-campaigns').text(active);
                $('#draft-campaigns').text(draft);
                $('#closed-campaigns').text(closed);
            }
        });
    }

    updateStats();

    // Filter functionality
    $('#status-filter').on('change', function () {
        let status = $(this).val();
        table.column(4).search(status).draw();
    });

    // Création d'une campagne
    $('#create-campaign-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: '{{ url("campaigns") }}',
            type: 'POST',
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
            success: function () {
                $('#createCampaignModal').modal('hide');
                $('#create-campaign-form')[0].reset();
                table.ajax.reload();
                updateStats();
            },
            error: function (xhr) {
                alert('Erreur lors de la création de la campagne : ' + xhr.responseText);
            }
        });
    });

    // Modification d'une campagne
    $(document).on('click', '.edit-btn', function () {
        let id = $(this).data('id');
        $.ajax({
            url: '{{ url("campaigns") }}/' + id,
            type: 'GET',
            success: function (campaign) {
                $('#edit_id').val(campaign.id);
                $('#edit_title').val(campaign.title);
                $('#edit_description').val(campaign.description);
                $('#edit_start_date').val(campaign.start_date);
                $('#edit_end_date').val(campaign.end_date);
                $('#edit_status').val(campaign.status);
                $('#edit_user_id').val(campaign.user_id);
                $('#editCampaignModal').modal('show');
            },
            error: function (xhr) {
                alert('Erreur lors du chargement de la campagne : ' + xhr.responseText);
            }
        });
    });

    $('#edit-campaign-form').submit(function (e) {
        e.preventDefault();
        let id = $('#edit_id').val();
        $.ajax({
            url: '{{ url("campaigns") }}/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
            success: function () {
                $('#editCampaignModal').modal('hide');
                table.ajax.reload();
                updateStats();
            },
            error: function (xhr) {
                alert('Erreur lors de la mise à jour de la campagne : ' + xhr.responseText);
            }
        });
    });

    // Suppression d'une campagne
    $(document).on('click', '.delete-btn', function () {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette campagne ?')) {
            let id = $(this).data('id');
            $.ajax({
                url: '{{ url("campaigns") }}/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
                success: function () {
                    table.ajax.reload();
                    updateStats();
                },
                error: function (xhr) {
                    alert('Erreur lors de la suppression de la campagne : ' + xhr.responseText);
                }
            });
        }
    });
});
</script>

<style>
/* Amélioration du style pour DataTables */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    margin: 10px 0;
}

.dataTables_wrapper .dataTables_filter input {
    border-radius: 0.25rem;
    border: 1px solid #ced4da;
    padding: 0.375rem 0.75rem;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 0.25rem;
    margin: 0 2px;
    padding: 0.25rem 0.5rem;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #0d6efd;
    color: white !important;
    border: none;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #0d6efd;
    color: white !important;
    border: none;
}

/* Responsive design pour petits écrans */
@media (max-width: 576px) {
    .modal-dialog {
        margin: 0.5rem;
    }

    .btn-sm {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
    }
}
</style>
@endsection
