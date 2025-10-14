@extends('back.layout')

@section('content')
<div class="min-vh-100 d-flex justify-content-center align-items-center" style="background-color: #f8f9fa;">
    <div class="container py-5">
        <div class="card shadow-lg border-0 mx-auto" style="max-width: 1000px; width: 100%; border-radius: 1rem;">
            
            <!-- Header -->
            <div class="card-header bg-success text-white text-center py-4" style="border-radius: 1rem 1rem 0 0;">
                <h2 class="fw-bold mb-0">AI Waste Prediction ♻️</h2>
            </div>

            <div class="card-body p-5">
                <!-- Error Alert -->
                <div id="errorDiv" class="alert alert-danger d-none" role="alert"></div>

                <!-- Prediction Form -->
                <form id="predictForm">
                    @csrf

                    <div class="row g-4">
                        <!-- Type -->
                        <div class="col-md-6">
                            <label for="type" class="form-label fw-semibold">Waste Type</label>
                            <input type="text" name="type" id="type" class="form-control" required>
                        </div>

                        <!-- Weight -->
                        <div class="col-md-6">
                            <label for="weight" class="form-label fw-semibold">Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" id="weight" class="form-control" required>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <label for="category" class="form-label fw-semibold">Category</label>
                            <input type="text" name="category" id="category" class="form-control" required>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <input type="text" name="description" id="description" class="form-control">
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-cpu me-2"></i>Send to AI
                        </button>
                    </div>
                </form>

                <!-- Prediction Result -->
                <div id="predictionDiv" class="alert alert-success text-center mt-5 d-none" role="alert">
                    <h5 class="fw-bold mb-0" id="predictionText"></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.getElementById('predictForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const errorDiv = document.getElementById('errorDiv');
    const predictionDiv = document.getElementById('predictionDiv');
    const predictionText = document.getElementById('predictionText');

    fetch("{{ route('ai.predict') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.prediction) {
            predictionText.innerText = "Predicted Result: " + data.prediction;
            predictionDiv.classList.remove('d-none');
            errorDiv.classList.add('d-none');
        } else {
            errorDiv.innerText = "No prediction received from the AI.";
            errorDiv.classList.remove('d-none');
            predictionDiv.classList.add('d-none');
        }
    })
    .catch(error => {
        console.error(error);
        errorDiv.innerText = "An error occurred while communicating with the AI.";
        errorDiv.classList.remove('d-none');
        predictionDiv.classList.add('d-none');
    });
});
</script>
@endsection
