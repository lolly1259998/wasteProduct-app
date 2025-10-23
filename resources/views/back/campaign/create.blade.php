<!-- Modal: Create Campaign -->
<div class="modal fade" id="createCampaignModal" tabindex="-1" aria-labelledby="createCampaignLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(135deg, #22a065ff, #2e7d32); color: white;">
        <h5 class="modal-title" id="createCampaignLabel">
          <i class="bi bi-megaphone-fill"></i> New Campaign
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="createCampaignForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">

          <div class="mb-3">
            <label for="createTitle" class="form-label">Campaign Title</label>
            <input type="text" name="title" id="createTitle" class="form-control" placeholder="Ex: Awareness Campaign" required>
          </div>

          <div class="mb-3">
    <label for="description" class="form-label fw-bold">Description</label>
    <textarea class="form-control" id="description" name="description" rows="4"
              placeholder="Saisir la description ou la générer avec l'IA..."></textarea>
    <div class="d-flex justify-content-end mt-2">
        <button type="button" id="generateAI" class="btn btn-outline-success btn-sm">
            <i class="bi bi-robot me-1"></i> Générer avec IA
        </button>
    </div>
    <div id="ai-loader" class="text-success mt-2" style="display:none;">
        <i class="bi bi-hourglass-split"></i> L’IA rédige la description...
    </div>
</div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="createStartDate" class="form-label">Start Date</label>
              <input type="date" name="start_date" id="createStartDate" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="createEndDate" class="form-label">End Date</label>
              <input type="date" name="end_date" id="createEndDate" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="createDeadline" class="form-label">Registration Deadline</label>
            <input type="date" name="deadline_registration" id="createDeadline" class="form-control">
          </div>

          <div class="mb-3">
            <label for="createImage" class="form-label">Campaign Image</label>
            <input type="file" name="image" id="createImage" class="form-control" accept="image/*">
          </div>

         <div class="row">
  <div class="col-md-6 mb-3">
    <label for="createCity" class="form-label">Address (Full)</label>
    <input type="text" name="city" id="createCity" class="form-control" placeholder="Click on map to autofill address" required>
  </div>
  <div class="col-md-6 mb-3">
    <label for="createRegion" class="form-label">Region / State</label>
    <input type="text" name="region" id="createRegion" class="form-control" placeholder="Auto-filled" required>
  </div>
</div>

          <!-- 🗺️ Map Picker -->
          <div class="mb-3">
            <label class="form-label">Select Location on Map</label>
            <div id="map" style="height: 300px; border-radius: 10px;"></div>
          </div>

      

          <div class="mb-3">
            <label for="createStatus" class="form-label">Status</label>
            <select name="status" id="createStatus" class="form-select">
              <option value="draft">Draft</option>
              <option value="active">Active</option>
              <option value="closed">Closed</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Leaflet CSS + JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const mapContainer = document.getElementById('map');
  if (!mapContainer) return;

  // 🗺️ Initialiser la carte centrée sur la Tunisie
  const map = L.map('map').setView([36.8065, 10.1815], 8);

  // 🌍 Charger les tuiles OpenStreetMap
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  let marker;

  // 📍 Quand on clique sur la carte
  map.on('click', function(e) {
    if (marker) marker.setLatLng(e.latlng);
    else marker = L.marker(e.latlng).addTo(map);

    // 🔎 Reverse geocoding (coordonnées → adresse complète)
    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${e.latlng.lat}&lon=${e.latlng.lng}&format=json`)
      .then(res => res.json())
      .then(data => {
        if (data && data.address) {
          // 🏙️ Construire une adresse complète
          const addr = data.display_name || '';
          const state = data.address.state || '';
          const region = data.address.county || '';
          
          // 🔄 Mettre à jour les champs du formulaire
          document.getElementById('createCity').value = addr; // adresse complète
          document.getElementById('createRegion').value = state || region;
        }
      });
  });

  // ✅ Correction d'affichage : redimensionner la carte quand le modal s'ouvre
  const createModal = document.getElementById('createCampaignModal');
  createModal.addEventListener('shown.bs.modal', () => {
    setTimeout(() => map.invalidateSize(), 200);
  });
});
</script>

<script>
$(document).ready(function () {
   $('#generateAI').on('click', function () {
    console.log('Bouton Générer avec IA cliqué !'); // Ajout pour débogage
    const title = $('#createTitle').val();
    const city = $('#createCity').val();
    const region = $('#createRegion').val();

    if (!title) {
        alert('Veuillez d’abord saisir un titre de campagne.');
        return;
    }

    $('#ai-loader').show();
    $('#generateAI').prop('disabled', true);

    $.ajax({
        url: 'http://127.0.0.1:5000/api/ai/generate-description',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ title, city, region }),
        success: function (res) {
            console.log('Réponse API :', res); // Ajout pour débogage
            if (res.description) {
                $('#description').val(res.description);
            } else {
                alert('Erreur IA : ' + res.error);
            }
            $('#ai-loader').hide();
            $('#generateAI').prop('disabled', false);
        },
        error: function (xhr) {
            console.log('Erreur complète :', xhr.responseText); // Déjà présent
            alert('Erreur de communication avec l’IA.');
            $('#ai-loader').hide();
            $('#generateAI').prop('disabled', false);
        }
    });
});
});
</script>

