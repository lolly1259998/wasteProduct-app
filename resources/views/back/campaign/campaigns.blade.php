@extends('back.layout')

@section('content')
<style>

/* Section Statistiques */
.campaign-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 1.8rem;
    backdrop-filter: blur(12px);
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
    color: #fff;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.stat-card::before {
    content: "";
    position: absolute;
    top: -40%;
    right: -40%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at top right, rgba(255,255,255,0.2), transparent 70%);
    transform: rotate(25deg);
}

.stat-icon {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    opacity: 0.9;color:  #1b4332;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;color:  #1b4332;
}

.stat-label {
    opacity: 0.9;
    font-size: 0.95rem;
    letter-spacing: 0.5px;    color:  #1b4332;

}

.stats-wrapper {
background: linear-gradient(135deg, #f2dd94, #e8c471);
     border-radius: 25px;
    padding: 2rem;
    color:  #1b4332;
    margin-bottom: 2.5rem;
}

.table-card {
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 6px 30px rgba(0,0,0,0.08);
    overflow: hidden;
    border: none;
}

.table-header {
    background: linear-gradient(135deg, #007bff, #00c9a7);
    color: white;
    font-weight: 600;
}

.table thead th {
    text-align: center;
    padding: 1rem;
    vertical-align: middle;
}

.table tbody tr {
    transition: all 0.25s ease;
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

.table td {
    vertical-align: middle;
    text-align: center;
    padding: 0.9rem;
}

/* Boutons d’action */
.btn-action {
    border: none;
    border-radius: 10px;
    padding: 0.4rem 0.7rem;
    transition: all 0.3s ease;
}

.btn-action:hover {
    transform: scale(1.1);
}

/* Filtres et en-tête */
.page-header {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.page-header h2 {
    font-weight: 700;
    color: #0d6efd;
}

.page-header select {
    border-radius: 10px;
    border: 1px solid #dee2e6;
    padding: 0.5rem 1rem;
}

.btn-add {
    background: linear-gradient(135deg, #00c9a7, #007bff);
    border: none;
    color: white;
    border-radius: 30px;
    padding: 0.7rem 1.8rem;
    font-weight: 600;
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

.btn-add:hover {
    background: linear-gradient(135deg, #007bff, #00c9a7);
    transform: translateY(-2px);
}

/* Animation douce */
.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(25px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .stats-wrapper {
        padding: 1rem;
    }
    .btn-add {
        width: 100%;
        margin-top: 1rem;
    }
}
</style>

<div class="container-fluid py-4 fade-in-up">
    <!-- Statistiques -->
    <div class="stats-wrapper fade-in-up">
    <div class="campaign-stats">
        <div class="stat-card bg-gradient-primary">
            <i class="bi bi-collection-fill stat-icon"></i>
            <div class="stat-number" id="total-campaigns">0</div>
            <div class="stat-label">Total Campagnes</div>
        </div>
        <div class="stat-card bg-gradient-success">
            <i class="bi bi-lightning-charge-fill stat-icon"></i>
            <div class="stat-number" id="active-campaigns">0</div>
            <div class="stat-label">Active Campaigns</div>
        </div>
        <div class="stat-card bg-gradient-warning">
            <i class="bi bi-pencil-square stat-icon"></i>
            <div class="stat-number" id="draft-campaigns">0</div>
            <div class="stat-label">Draft</div>
        </div>
        <div class="stat-card bg-gradient-secondary">
            <i class="bi bi-archive stat-icon"></i>
            <div class="stat-number" id="closed-campaigns">0</div>
            <div class="stat-label">Closed</div>
        </div>
    </div>
</div>


    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success mb-0">
            <i class="bi bi-megaphone-fill me-2"></i>Gestion des Campagnes
        </h2>
        <div class="d-flex gap-2">
            <select id="status-filter" class="form-select form-select-sm">
    <option value="">Tous les statuts</option>
    <option value="draft">Draft</option>
    <option value="active">Active</option>
    <option value="closed">Closed</option>
</select>

            <button class="btn btn-success btn-custom" data-bs-toggle="modal" data-bs-target="#createCampaignModal">
                <i class="bi bi-plus-circle-fill me-2"></i>Nouvelle Campagne
            </button>
        </div>
    </div>

    <!-- Tableau -->
    <div class=" campaign-table border-0">
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

<!-- Modal : Création -->
@include('back.campaign.create')

<!-- Modal : Édition -->
@include('back.campaign.edit')

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function () {
    let table = $('#campaigns-table').DataTable({
        responsive: true,
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json' },
        ajax: { url: '{{ url("campaigns") }}', dataSrc: '' },
        columns: [
            { data: 'id' },
            { data: 'title', render: data => `<strong>${data}</strong>` },
            { data: 'description', defaultContent: '' },
            { data: null, render: data => `${data.start_date} → ${data.end_date}` },
            { 
    data: 'status', 
    render: function(data, type, row) {
        const map = { draft: ['warning','Draft'], active:['success','Actif'], closed:['secondary','Clôturé'] };
        if(type === 'display') {
            return `<span class="badge bg-${map[data][0]}">${map[data][1]}</span>`; // affichage
        }
        return data; // valeur brute pour filtrage
    }
}
,
            { data: 'user', render: data => data ? data.name : 'N/A' },
            { data: null, orderable: false, render: data => `
                <button class="btn btn-sm btn-outline-warning edit-btn" data-id="${data.id}"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${data.id}"><i class="bi bi-trash"></i></button>`}
        ]
    });

    // === Statistiques ===
    function updateStats() {
        $.get('{{ url("campaigns") }}', data => {
            $('#total-campaigns').text(data.length);
            $('#active-campaigns').text(data.filter(c=>c.status==='active').length);
            $('#draft-campaigns').text(data.filter(c=>c.status==='draft').length);
            $('#closed-campaigns').text(data.filter(c=>c.status==='closed').length);
        });
    }
    updateStats();

    // === Filtres ===
// Filtre par statut
$('#status-filter').on('change', function () {
    let val = $(this).val(); // draft / active / closed / ""
    table.column(4).search(val).draw(); // colonne 4 = status
});


    // === Création ===
   // Création
$('#createCampaignForm').on('submit', e => {
    e.preventDefault();
    $.post('{{ url("campaigns") }}', $('#createCampaignForm').serialize())
    .done(() => {
        $('#createCampaignModal').modal('hide');
        $('#createCampaignForm')[0].reset();
        table.ajax.reload();
        updateStats();
    }).fail(xhr => alert('Erreur création : ' + xhr.responseText));
});

// Édition
$('#editCampaignForm').on('submit', function(e) {
    e.preventDefault();
    let id = $('#editCampaignId').val();

    $.ajax({
        url: `{{ url("campaigns") }}/${id}`,
        type: 'PUT',
        data: $(this).serialize(),
        success: function() {
            $('#editCampaignModal').modal('hide');
            table.ajax.reload();
            updateStats();
        },
        error: function(xhr) {
            alert('Erreur mise à jour : ' + xhr.responseText);
        }
    });
});


  // Édition d’une campagne
$(document).on('click', '.edit-btn', function () {
    let id = $(this).data('id');
    
    $.get(`{{ url("campaigns") }}/${id}`, function(campaign) {
        // Remplir les champs du modal
        $('#editCampaignId').val(campaign.id);
        $('#editTitle').val(campaign.title);
        $('#editDescription').val(campaign.description);
        $('#editStartDate').val(campaign.start_date);
        $('#editEndDate').val(campaign.end_date);
        $('#editStatus').val(campaign.status);

        // Afficher le modal
        $('#editCampaignModal').modal('show');
    }).fail(function(xhr) {
        alert('Erreur récupération campagne : ' + xhr.responseText);
    });
});


   
    // === Suppression ===
    $(document).on('click', '.delete-btn', function () {
        if (confirm('Confirmer la suppression ?')) {
            $.ajax({
                url: `{{ url("campaigns") }}/${$(this).data('id')}`,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: () => {
                    table.ajax.reload();
                    updateStats();
                },
                error: xhr => alert('Erreur suppression : ' + xhr.responseText)
            });
        }
    });
});
</script>

<style>
/* 🔧 Amélioration DataTables */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    margin: 10px 0;
}
.dataTables_wrapper .dataTables_filter input {
    border-radius: .25rem;
    border: 1px solid #ced4da;
    padding: .375rem .75rem;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: .25rem;
    margin: 0 2px;
    padding: .25rem .5rem;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #198754;
    color: white !important;
    border: none;
}
</style>
@endsection
