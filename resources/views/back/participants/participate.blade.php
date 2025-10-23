@extends('back.layout')

@section('content')
<div class="container-fluid py-4 fade-in-up">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success mb-0">
            <i class="bi bi-people-fill me-2"></i> Participants Management
        </h2>
        <a href="{{ url('back/campaigns') }}" class="btn btn-outline-success">
            <i class="bi bi-arrow-left"></i> View Campaigns
        </a>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="card-body p-0">
            <table id="participants-table" class="table table-hover align-middle w-100 mb-0">
                <thead class="table-light">
                    <tr>
                        <th><i class="bi bi-person"></i> Name</th>
                        <th><i class="bi bi-envelope"></i> Email</th>
                        <th><i class="bi bi-flag"></i> Status</th>
                        <th><i class="bi bi-calendar"></i> Joined At</th>
                        <th><i class="bi bi-gear"></i> Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    const campaignId = "{{ request()->segment(3) }}"; // récupère l’ID de la campagne depuis l’URL

    $('#participants-table').DataTable({
    ajax: {
        url: '/admin/participants/{{ $campaign->id }}', // ✅ fonctionne maintenant
        dataSrc: ''
    },
    columns: [
    { data: 'user_name', defaultContent: '—' },
    { data: 'user_email', defaultContent: '—' },
    { data: 'status', defaultContent: 'pending' },
    { data: 'joined_at', defaultContent: '—' },
    {
        data: null,
        render: function (data) {
            return `
                <button class="btn btn-success btn-sm approve-btn" data-id="${data.id}">
                    <i class="bi bi-check-circle"></i>
                </button>
                <button class="btn btn-danger btn-sm delete-btn" data-id="${data.id}">
                    <i class="bi bi-trash"></i>
                </button>
            `;
        }
    }
]

});


    // ✅ Approuver participant
    $(document).on('click', '.approve-btn', function() {
        let id = $(this).data('id');
        $.ajax({
            url: `/admin/participants/${id}/approve`,
            type: 'PUT',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: () => table.ajax.reload(),
            error: xhr => alert('Error approving: ' + xhr.responseText)
        });
    });

    // ❌ Supprimer participant
    $(document).on('click', '.delete-btn', function() {
        if (confirm('Remove this participant?')) {
            let id = $(this).data('id');
            $.ajax({
                url: `/admin/participants/${id}`,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: () => table.ajax.reload(),
                error: xhr => alert('Error deleting: ' + xhr.responseText)
            });
        }
    });
});
</script>
@endsection
