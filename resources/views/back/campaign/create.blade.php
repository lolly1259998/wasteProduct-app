<!-- Modal : Créer une campagne -->
<div class="modal fade" id="createCampaignModal" tabindex="-1" aria-labelledby="createCampaignLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #22a065ff, #2e7d32); color: white;">
                <h5 class="modal-title" id="createCampaignLabel">
                    <i class="bi bi-megaphone-fill"></i> Nouvelle Campagne
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <form id="createCampaignForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="createTitle" class="form-label">Titre de la campagne</label>
                        <input type="text" name="title" id="createTitle" class="form-control" placeholder="Ex: Campagne de sensibilisation" required>
                    </div>

                    <div class="mb-3">
                        <label for="createDescription" class="form-label">Description</label>
                        <textarea name="description" id="createDescription" rows="4" class="form-control" placeholder="Décris brièvement l'objectif de cette campagne..." required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="createStartDate" class="form-label">Date de début</label>
                            <input type="date" name="start_date" id="createStartDate" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="createEndDate" class="form-label">Date de fin</label>
                            <input type="date" name="end_date" id="createEndDate" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="createStatus" class="form-label">Statut</label>
                          <select name="status" id="editStatus" class="form-select">
    <option value="draft">draft</option>
    <option value="active">Active</option>
    <option value="closed">closed</option>
</select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
