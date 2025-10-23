@extends('back.layout')

@section('content')
<div class="container-fluid py-4 fade-in-up">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">
      <i class="bi bi-people-fill me-2"></i> Users Management
    </h2>
  </div>

  <div class="table-card">
    <div class="card-body p-0">
      <table id="users-table" class="table table-hover align-middle w-100 mb-0">
        <thead class="table-light">
          <tr>
            <th><i class="bi bi-person"></i> Name</th>
            <th><i class="bi bi-envelope"></i> Email</th>
            <th><i class="bi bi-telephone"></i> Phone</th>
            <th><i class="bi bi-house"></i> Address</th>

            <th><i class="bi bi-geo-alt"></i> City</th>
            <th><i class="bi bi-shield-lock"></i> Role</th>
            <th><i class="bi bi-gear"></i> Actions</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editUserForm">
          @csrf
          @method('PUT')
          <input type="hidden" id="editUserId">
          <div class="mb-3">
            <label>Name</label>
            <input type="text" id="editName" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" id="editEmail" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Phone</label>
            <input type="text" id="editPhone" name="phone" class="form-control">
          </div>
          <div class="mb-3">
            <label>Address</label>
            <input type="text" id="editAddress" name="address" class="form-control">
          </div>
          <div class="mb-3">
            <label>City</label>
            <input type="text" id="editCity" name="city" class="form-control">
          </div>
          <div class="mb-3">
  <label>Role</label>
  <select id="editRole" name="role_id" class="form-select">
    <option value="">Select role</option>
    @foreach ($roles as $role)
      <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
    @endforeach
  </select>
</div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="saveEdit" class="btn btn-success">Save</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
  const table = $('#users-table').DataTable({
    ajax: {
      url: '{{ route("back.users") }}/list',
      dataSrc: ''
    },
    columns: [
      { data: 'name' },
      { data: 'email' },
      { data: 'phone', defaultContent: '—' },
      { data: 'address', defaultContent: '—' },
      { data: 'city', defaultContent: '—' },
      { data: 'role_name', defaultContent: '—' },
      {
        data: null,
        render: data => `
          <button class="btn btn-sm btn-outline-warning edit-btn" data-id="${data.id}">
            <i class="bi bi-pencil"></i>
          </button>
          <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${data.id}">
            <i class="bi bi-trash"></i>
          </button>
        `
      }
    ]
  });

  // 🟢 Lorsqu’on clique sur “Edit”
  $(document).on('click', '.edit-btn', function() {
    const row = table.row($(this).parents('tr')).data();

    // Remplir tous les champs du formulaire avec les données existantes
    $('#editUserId').val(row.id);
    $('#editName').val(row.name || '');
    $('#editEmail').val(row.email || '');
    $('#editPhone').val(row.phone || '');
    $('#editAddress').val(row.address || '');
    $('#editCity').val(row.city || '');
    $('#editRole').val(row.role_id || '').change(); // 🟢 sélectionne le bon rôle

    // Ouvrir la modale
    $('#editUserModal').modal('show');
  });

  // 💾 Sauvegarder les modifications
  $('#saveEdit').click(function() {
    const id = $('#editUserId').val();
    $.ajax({
      url: `/back/users/${id}`,
      type: 'PUT',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      data: $('#editUserForm').serialize(),
      success: function() {
        $('#editUserModal').modal('hide');
        table.ajax.reload();
      },
      error: function(xhr) {
        alert('Erreur : ' + xhr.responseText);
      }
    });
  });

  // ❌ Supprimer un utilisateur
  $(document).on('click', '.delete-btn', function() {
    if (confirm('Are you sure you want to delete this user?')) {
      const id = $(this).data('id');
      $.ajax({
        url: `/back/users/${id}`,
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: () => table.ajax.reload(),
        error: (xhr) => alert('Erreur : ' + xhr.responseText)
      });
    }
  });
});
</script>
@endsection
