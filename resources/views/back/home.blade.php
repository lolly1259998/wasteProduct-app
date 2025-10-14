@extends('back.layout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 text-green-500 text-center">Waste Distribution ♻️</h1>

    <!-- Conteneur pour centrer le graphique et limiter la taille -->
    <div style="max-width: 400px; margin: 0 auto;">
        <canvas id="wasteChart"></canvas>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('wasteChart').getContext('2d');

    const data = {
        labels: {!! json_encode($wasteStats->pluck('name')) !!},
        datasets: [{
            label: 'Répartition (%)',
            data: {!! json_encode($wasteStats->pluck('percentage')) !!},
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',   // Papier
                'rgba(54, 162, 235, 0.6)',   // Plastique
                'rgba(255, 206, 86, 0.6)',   // Métal
                'rgba(75, 192, 192, 0.6)',   // Verre
                'rgba(153, 102, 255, 0.6)'   // Autres
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'pie', // graphique circulaire
        data: data,
        options: {
            responsive: true,           // adapte le graphique à la taille du conteneur
            maintainAspectRatio: true,  // garde le cercle parfait
            plugins: {
                legend: {
                    position: 'bottom', // légende sous le graphique
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + '%';
                        }
                    }
                }
            }
        }
    };

    new Chart(ctx, config);
</script>

<!-- CSS optionnel pour forcer la taille exacte -->
<style>
    #wasteChart {
        width: 100%;
        height: 400px; /* largeur = hauteur pour cercle parfait */
    }
</style>
@endsection
