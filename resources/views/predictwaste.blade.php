@extends('back.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-teal-100 dark:from-zinc-800 dark:to-zinc-900">
    <div class="container py-8">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h1 class="text-2xl font-bold mb-6 text-green-700 dark:text-green-300 text-center">AI Waste Prediction ♻️</h1>

                        <!-- Affichage des erreurs -->
                        <div id="errorDiv" class="mb-4 p-3 bg-red-100 dark:bg-red-900 border-l-2 border-red-500 dark:border-red-700 text-red-700 dark:text-red-200 rounded" style="display:none;"></div>

                        <form id="predictForm" class="space-y-4">
                            @csrf

                            <!-- Type -->
                            <div class="mb-3">
                                <label for="type" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Type</label>
                                <input type="text" name="type" id="type" class="form-control" required>
                            </div>

                            <!-- Poids -->
                            <div class="mb-3">
                                <label for="weight" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Poids (kg)</label>
                                <input type="number" step="0.01" name="weight" id="weight" class="form-control" required>
                            </div>

                            <!-- Catégorie -->
                            <div class="mb-3">
                                <label for="category" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Catégorie</label>
                                <input type="text" name="category" id="category" class="form-control" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Description</label>
                                <input type="text" name="description" id="description" class="form-control">
                            </div>

                            <!-- Bouton -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success btn-md">Envoyer à l'IA</button>
                            </div>
                        </form>

                        <!-- Affichage prédiction -->
                        <div id="predictionDiv" class="mt-6 p-4 bg-green-100 dark:bg-green-900 border-l-4 border-green-500 dark:border-green-700 text-green-700 dark:text-green-200 rounded text-center" style="display:none;">
                            <h2 class="text-xl font-semibold" id="predictionText"></h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('predictForm').addEventListener('submit', function(e){
    e.preventDefault();

    const formData = new FormData(this);

    fetch("{{ route('ai.predict') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.prediction){
            document.getElementById('predictionText').innerText = data.prediction;
            document.getElementById('predictionDiv').style.display = 'block';
            document.getElementById('errorDiv').style.display = 'none';
        }
    })
    .catch(error => {
        console.error(error);
        document.getElementById('errorDiv').innerText = 'Une erreur est survenue.';
        document.getElementById('errorDiv').style.display = 'block';
        document.getElementById('predictionDiv').style.display = 'none';
    });
});
</script>
@endsection
