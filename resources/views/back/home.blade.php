@extends('back.layout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 text-green-500 text-center">Répartition des déchets ♻️</h1>

    <canvas id="wasteChart" width="400" height="200"></canvas>
</div>

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
        type: 'pie', // ou 'bar' pour un histogramme
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
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
@endsection
