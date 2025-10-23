<!-- Modal: Edit Campaign -->
<div class="modal fade" id="editCampaignModal" tabindex="-1" aria-labelledby="editCampaignLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(135deg, #22a065ff, #2e7d32); color: white;">
        <h5 class="modal-title" id="editCampaignLabel">
          <i class="bi bi-pencil-square"></i> Edit Campaign
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="editCampaignForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="editCampaignId" name="id">

        <div class="modal-body">

          <div class="mb-3">
            <label for="editTitle" class="form-label">Campaign Title</label>
            <input type="text" name="title" id="editTitle" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="editDescription" class="form-label">Description</label>
            <textarea name="description" id="editDescription" rows="4" class="form-control" required></textarea>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="editStartDate" class="form-label">Start Date</label>
              <input type="date" name="start_date" id="editStartDate" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="editEndDate" class="form-label">End Date</label>
              <input type="date" name="end_date" id="editEndDate" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="editDeadline" class="form-label">Registration Deadline</label>
            <input type="date" name="deadline_registration" id="editDeadline" class="form-control">
          </div>

          <div class="mb-3">
            <label for="editImage" class="form-label">Campaign Image</label>
            <input type="file" name="image" id="editImage" class="form-control" accept="image/*">
            <div id="editImagePreview" class="mt-2"></div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="editCity" class="form-label">Address (Full)</label>
              <input type="text" name="city" id="editCity" class="form-control" placeholder="Click on map to update address" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="editRegion" class="form-label">Region / State</label>
              <input type="text" name="region" id="editRegion" class="form-control" required>
            </div>
          </div>

          <!-- 🗺️ Map Picker -->
          <div class="mb-3">
            <label class="form-label">Select Location on Map</label>
            <div id="editMap" style="height: 300px; border-radius: 10px;"></div>
          </div>

         

          <div class="mb-3">
            <label for="editStatus" class="form-label">Status</label>
            <select name="status" id="editStatus" class="form-select">
              <option value="draft">Draft</option>
              <option value="active">Active</option>
              <option value="closed">Closed</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Leaflet CSS + JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const mapContainer = document.getElementById('editMap');
  if (!mapContainer) return;

  // 🗺️ Initialiser la carte centrée sur la Tunisie
const map = L.map('editMap', { center: [36.8065, 10.1815], zoom: 8, zoomControl: true });
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  let marker;

map.on('click', function(e) {
  if (marker) marker.setLatLng(e.latlng);
  else marker = L.marker(e.latlng).addTo(map);

  // 🧠 Si l'utilisateur clique, alors seulement on change l'adresse
  fetch(`https://nominatim.openstreetmap.org/reverse?lat=${e.latlng.lat}&lon=${e.latlng.lng}&format=json`)
    .then(res => res.json())
    .then(data => {
      if (data && data.address) {
        const addr = data.display_name || '';
        const state = data.address.state || '';
        // 🔥 Mise à jour uniquement si l'utilisateur a cliqué
        document.getElementById('editCity').value = addr;
        document.getElementById('editRegion').value = state;
      }
    })
    .catch(err => console.error('Error fetching address:', err));
});

  // ✅ Ajuster la taille du map quand le modal s’ouvre
  const editModal = document.getElementById('editCampaignModal');
  editModal.addEventListener('shown.bs.modal', () => {
    setTimeout(() => map.invalidateSize(), 200);
  });

  // 🖼️ Prévisualisation image
  document.getElementById('editImage').addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
      document.getElementById('editImagePreview').innerHTML =
        `<img src="${ev.target.result}" class="mt-2" style="width:100px;height:100px;border-radius:10px;object-fit:cover;">`;
    };
    reader.readAsDataURL(file);
  });
});
</script>
