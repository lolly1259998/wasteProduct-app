
@extends('back.layout')
<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prédictions IA - Points de Collecte | Waste2Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #1a1f36;
            --sidebar-hover: #2d3748;
            --primary-color: #10b981;
            --text-light: #e2e8f0;
            --text-muted: #94a3b8;
        }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: #f8fafc;
        }
        .sidebar {
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #0f172a 100%);
            width: 280px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .sidebar-header {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
        }
        .brand-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), #059669);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .brand-text {
            font-weight: 700;
            font-size: 1.25rem;
            background: linear-gradient(135deg, #fff, var(--text-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .sidebar-nav {
            padding: 1rem 0;
        }
        .nav-section {
            margin-bottom: 1.5rem;
        }
        .nav-section-title {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 1.5rem 0.5rem;
            margin-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .nav-item {
            margin: 0.25rem 0.75rem;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1rem;
            color: var(--text-light);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--primary-color);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        .nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
            transform: translateX(4px);
        }
        .nav-link:hover::before {
            transform: scaleY(1);
        }
        .nav-link.active {
            background: rgba(16, 185, 129, 0.15);
            color: var(--primary-color);
            border-left: 3px solid var(--primary-color);
        }
        .nav-link.active::before {
            transform: scaleY(1);
        }
        .nav-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .nav-badge {
            margin-left: auto;
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
            background: #f8fafc;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: block !important;
            }
        }
        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: var(--sidebar-bg);
            border: none;
            color: white;
            border-radius: 8px;
            padding: 0.5rem;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .sidebar-overlay.show {
            display: block;
        }
        
        /* Styles pour le contenu des prédictions IA */
        .status-badge {
            @apply px-3 py-1 rounded-full text-sm font-medium;
        }
        .status-full {
            @apply bg-red-100 text-red-800;
        }
        .status-almost-full {
            @apply bg-orange-100 text-orange-800;
        }
        .status-normal {
            @apply bg-green-100 text-green-800;
        }
        .status-unknown {
            @apply bg-gray-100 text-gray-800;
        }
        .card {
            @apply bg-white rounded-xl shadow-md overflow-hidden;
        }
        .loading-pulse {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="h-100">
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="bi bi-list"></i>
    </button>
 
   
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="container mx-auto px-4 py-6">
            <!-- En-tête avec informations -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-chart-line text-blue-500 mr-3"></i>
                        Prédictions IA des Points de Collecte
                    </h1>
                    <p class="text-gray-600 mt-2">Analyse prédictive des volumes de déchets pour optimiser la collecte</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <div class="flex items-center text-blue-700">
                        <i class="fas fa-clock mr-2"></i>
                        <span class="font-medium">Dernière mise à jour :</span>
                        <span id="lastUpdateTime" class="ml-2">{{ now()->format('H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Cartes de statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="card p-4 border-l-4 border-blue-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Points surveillés</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ count($collectionPoints) }}</h3>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-map-marker-alt text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="card p-4 border-l-4 border-green-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Statut normal</p>
                            <h3 id="normalCount" class="text-2xl font-bold text-gray-800">-</h3>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="card p-4 border-l-4 border-orange-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Presque plein</p>
                            <h3 id="almostFullCount" class="text-2xl font-bold text-gray-800">-</h3>
                        </div>
                        <div class="bg-orange-100 p-3 rounded-full">
                            <i class="fas fa-exclamation-triangle text-orange-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="card p-4 border-l-4 border-red-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Plein</p>
                            <h3 id="fullCount" class="text-2xl font-bold text-gray-800">-</h3>
                        </div>
                        <div class="bg-red-100 p-3 rounded-full">
                            <i class="fas fa-times-circle text-red-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contrôles -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div class="flex flex-wrap gap-2">
                    <button id="refreshPredictions" class="btn btn-primary bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center shadow-sm">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Actualiser les prédictions
                        <span id="loadingSpinner" class="ml-2 hidden">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>
                    
                    <button id="exportData" class="btn bg-white text-gray-700 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 transition duration-200 flex items-center shadow-sm">
                        <i class="fas fa-download mr-2"></i>
                        Exporter les données
                    </button>
                </div>
                
                <div class="flex items-center bg-white rounded-lg border border-gray-300 px-3 py-2 shadow-sm">
                    <i class="fas fa-search text-gray-400 mr-2"></i>
                    <input type="text" id="searchInput" placeholder="Rechercher un point..." class="outline-none bg-transparent w-full md:w-64">
                </div>
            </div>

            <!-- Tableau des prédictions -->
            <div class="card mb-8 fade-in">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Points de collecte</h2>
                    <p class="text-gray-600 text-sm">Prédictions de volume et statuts en temps réel</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-4 text-left text-sm font-semibold text-gray-600">Point de collecte</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-600">Volume prédit</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-600">Statut</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-600">Dernière collecte</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="predictionsBody" class="divide-y divide-gray-200">
                            @foreach($collectionPoints as $point)
                            <tr id="row-{{ $point->id }}" class="hover:bg-gray-50 transition duration-150">
                                <td class="p-4">
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                            <i class="fas fa-trash-alt text-blue-500"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 point-name">{{ $point->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $point->address ?? 'Adresse non spécifiée' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td id="volume-{{ $point->id }}" class="p-4">
                                    <div class="loading-pulse bg-gray-200 h-6 w-16 rounded"></div>
                                </td>
                                <td id="status-{{ $point->id }}" class="p-4">
                                    <div class="loading-pulse bg-gray-200 h-6 w-24 rounded"></div>
                                </td>
                                <td id="lastCollection-{{ $point->id }}" class="p-4 text-gray-500">
                                    <div class="loading-pulse bg-gray-200 h-6 w-32 rounded"></div>
                                </td>
                                <td class="p-4">
                                    <button class="text-blue-500 hover:text-blue-700 transition duration-150" title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 text-sm text-gray-500 flex justify-between items-center">
                    <div>Affichage de <span id="visibleCount">{{ count($collectionPoints) }}</span> points sur {{ count($collectionPoints) }}</div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">Précédent</button>
                        <button class="px-3 py-1 border border-gray-300 rounded bg-blue-50 text-blue-600 border-blue-200">1</button>
                        <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">Suivant</button>
                    </div>
                </div>
            </div>

            <!-- Graphique et informations complémentaires -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Graphique -->
                <div class="lg:col-span-2 card p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Évolution des volumes prédits</h2>
                        <div class="flex space-x-2">
                            <button id="chartDay" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg font-medium">Jour</button>
                            <button id="chartWeek" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Semaine</button>
                            <button id="chartMonth" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Mois</button>
                        </div>
                    </div>
                    <div class="relative">
                        <canvas id="volumeChart" height="250"></canvas>
                        <div id="noDataMessage" class="absolute inset-0 flex flex-col items-center justify-center text-gray-500 bg-white bg-opacity-90 hidden">
                            <i class="fas fa-chart-bar text-4xl mb-2 text-gray-300"></i>
                            <p class="text-lg">Pas assez de données pour afficher le graphique</p>
                            <p class="text-sm mt-1">Les données apparaîtront après la première actualisation</p>
                        </div>
                    </div>
                </div>
                
                <!-- Points prioritaires -->
                <div class="card p-5">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Points prioritaires</h2>
                    <p class="text-gray-600 mb-4">Points nécessitant une attention immédiate</p>
                    
                    <div id="priorityList" class="space-y-3">
                        <div class="loading-pulse bg-gray-200 h-16 rounded-lg"></div>
                        <div class="loading-pulse bg-gray-200 h-16 rounded-lg"></div>
                        <div class="loading-pulse bg-gray-200 h-16 rounded-lg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Gestion de la barre latérale mobile
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('show');
        });
        
        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('show');
        });

        // Script pour les prédictions IA
        const chartCtx = document.getElementById('volumeChart');
        const noDataMessage = document.getElementById('noDataMessage');
        let chart;
        let allPointsData = {};

        // Mettre à jour l'heure de dernière actualisation
        function updateLastUpdateTime() {
            const now = new Date();
            document.getElementById('lastUpdateTime').textContent = 
                `${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}`;
        }

        // Mettre à jour les compteurs de statut
        function updateStatusCounters() {
            const normalCount = document.querySelectorAll('.status-normal').length;
            const almostFullCount = document.querySelectorAll('.status-almost-full').length;
            const fullCount = document.querySelectorAll('.status-full').length;
            
            document.getElementById('normalCount').textContent = normalCount;
            document.getElementById('almostFullCount').textContent = almostFullCount;
            document.getElementById('fullCount').textContent = fullCount;
        }

        // Fonction pour créer un badge de statut
        function createStatusBadge(status) {
            let badgeClass, badgeText, icon;
            
            switch(status) {
                case "plein":
                    badgeClass = "status-full";
                    badgeText = "Plein";
                    icon = "fas fa-times-circle";
                    break;
                case "presque plein":
                    badgeClass = "status-almost-full";
                    badgeText = "Presque plein";
                    icon = "fas fa-exclamation-triangle";
                    break;
                case "normal":
                    badgeClass = "status-normal";
                    badgeText = "Normal";
                    icon = "fas fa-check-circle";
                    break;
                default:
                    badgeClass = "status-unknown";
                    badgeText = "Inconnu";
                    icon = "fas fa-question-circle";
            }
            
            return `<span class="status-badge ${badgeClass} flex items-center">
                      <i class="${icon} mr-1"></i>
                      ${badgeText}
                    </span>`;
        }

        // Fonction pour mettre à jour la liste des priorités
        function updatePriorityList() {
            const priorityList = document.getElementById('priorityList');
            const fullPoints = [];
            const almostFullPoints = [];
            
            // Récupérer les points prioritaires
            for (const [id, data] of Object.entries(allPointsData)) {
                if (data.status === "plein") {
                    fullPoints.push({id, ...data});
                } else if (data.status === "presque plein") {
                    almostFullPoints.push({id, ...data});
                }
            }
            
            // Trier par volume (décroissant)
            fullPoints.sort((a, b) => b.predicted_volume - a.predicted_volume);
            almostFullPoints.sort((a, b) => b.predicted_volume - a.predicted_volume);
            
            const priorityPoints = [...fullPoints, ...almostFullPoints].slice(0, 3);
            
            if (priorityPoints.length === 0) {
                priorityList.innerHTML = `
                    <div class="text-center py-4 text-gray-500">
                        <i class="fas fa-check-circle text-green-400 text-2xl mb-2"></i>
                        <p>Aucun point prioritaire</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            priorityPoints.forEach(point => {
                const statusClass = point.status === "plein" ? "status-full" : "status-almost-full";
                const statusIcon = point.status === "plein" ? "fas fa-times-circle" : "fas fa-exclamation-triangle";
                
                html += `
                <div class="border border-gray-200 rounded-lg p-3 hover:shadow-sm transition duration-150">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium text-gray-900">${point.name}</h3>
                            <p class="text-sm text-gray-500">${point.address || 'Adresse non spécifiée'}</p>
                        </div>
                        <span class="status-badge ${statusClass} flex items-center text-xs">
                            <i class="${statusIcon} mr-1"></i>
                            ${point.status === "plein" ? "Plein" : "Presque plein"}
                        </span>
                    </div>
                    <div class="mt-2 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">${Math.round(point.predicted_volume)} kg</span>
                        <button class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                            Planifier la collecte <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
                `;
            });
            
            priorityList.innerHTML = html;
        }

        async function fetchPredictions() {
            const refreshButton = document.getElementById('refreshPredictions');
            const loadingSpinner = document.getElementById('loadingSpinner');
            refreshButton.disabled = true;
            loadingSpinner.classList.remove('hidden');

            const rows = document.querySelectorAll('#predictionsBody tr');
            const labels = [];
            const dataValues = [];

            for (const row of rows) {
                const id = row.id.replace('row-', '');
                try {
                    const res = await fetch(`/collection-ai/predict/${id}`);
                    const data = await res.json();

                    const volumeElement = document.getElementById(`volume-${id}`);
                    const statusElement = document.getElementById(`status-${id}`);
                    const lastCollectionElement = document.getElementById(`lastCollection-${id}`);
                    const pointNameElement = row.querySelector('.point-name');
                    
                    // Stocker les données pour utilisation ultérieure
                    allPointsData[id] = {
                        ...data,
                        name: pointNameElement.textContent,
                        address: row.querySelector('td:first-child .text-sm').textContent
                    };
                    
                    // Mettre à jour le volume
                    volumeElement.innerHTML = `
                        <div class="font-bold text-lg text-gray-800">${Math.round(data.predicted_volume)}</div>
                        <div class="text-xs text-gray-500">kg</div>
                    `;
                    
                    // Mettre à jour le statut avec badge
                    statusElement.innerHTML = createStatusBadge(data.status);
                    
                    // Simuler une date de dernière collecte (à remplacer par vos données réelles)
                    const daysAgo = Math.floor(Math.random() * 7) + 1;
                    lastCollectionElement.innerHTML = `
                        <div class="text-gray-700">Il y a ${daysAgo} jour${daysAgo > 1 ? 's' : ''}</div>
                    `;
                    
                    // Ajouter les données pour le graphique - utiliser le nom réel du point
                    labels.push(pointNameElement.textContent);
                    dataValues.push(Math.round(data.predicted_volume));

                } catch (error) {
                    document.getElementById(`status-${id}`).innerHTML = `
                        <span class="status-badge status-unknown flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            Erreur
                        </span>
                    `;
                    console.error(`Erreur pour le point ${id}:`, error);
                }
            }

            // Mise à jour du graphique
            if (chart) chart.destroy();
            if (dataValues.length > 0) {
                noDataMessage.classList.add('hidden');
                
                // Configuration pour éviter que les labels soient trop longs
                const shortenedLabels = labels.map(label => {
                    if (label.length > 15) {
                        return label.substring(0, 15) + '...';
                    }
                    return label;
                });
                
                chart = new Chart(chartCtx, {
                    type: 'bar',
                    data: {
                        labels: shortenedLabels,
                        datasets: [{
                            label: "Volume prédit (kg)",
                            data: dataValues,
                            backgroundColor: dataValues.map((v, i) => {
                                const id = rows[i].id.replace('row-', '');
                                const status = allPointsData[id]?.status;
                                return status === "plein" ? 'rgba(239, 68, 68, 0.7)' :
                                       status === "presque plein" ? 'rgba(249, 115, 22, 0.7)' :
                                       status === "normal" ? 'rgba(34, 197, 94, 0.7)' : 'rgba(156, 163, 175, 0.7)';
                            }),
                            borderColor: dataValues.map(() => 'rgba(255, 255, 255, 1)'),
                            borderWidth: 2,
                            borderRadius: 4,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { 
                                beginAtZero: true, 
                                title: { 
                                    display: true, 
                                    text: 'Volume (kg)',
                                    font: { weight: 'bold' }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45,
                                    callback: function(value, index) {
                                        // Afficher le nom complet dans le tooltip
                                        return shortenedLabels[index];
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: { 
                                display: false
                            },
                            tooltip: { 
                                callbacks: { 
                                    title: function(context) {
                                        // Afficher le nom complet dans le tooltip
                                        return labels[context[0].dataIndex];
                                    },
                                    label: ctx => `${ctx.raw} kg` 
                                },
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                titleFont: { size: 14 },
                                bodyFont: { size: 14 },
                                padding: 10,
                                cornerRadius: 8
                            }
                        }
                    }
                });
            } else {
                noDataMessage.classList.remove('hidden');
            }

            // Mettre à jour les compteurs et la liste des priorités
            updateStatusCounters();
            updatePriorityList();
            
            // Mettre à jour l'heure de dernière actualisation
            updateLastUpdateTime();

            refreshButton.disabled = false;
            loadingSpinner.classList.add('hidden');
            
            // Ajouter un effet de mise à jour visuelle
            document.querySelectorAll('#predictionsBody tr').forEach(row => {
                row.classList.add('fade-in');
                setTimeout(() => row.classList.remove('fade-in'), 500);
            });
        }

        // Initialisation
        document.getElementById('refreshPredictions').addEventListener('click', fetchPredictions);
        
        // Recherche
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#predictionsBody tr');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const pointName = row.querySelector('.point-name').textContent.toLowerCase();
                if (pointName.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            document.getElementById('visibleCount').textContent = visibleCount;
        });
        
        // Boutons de période pour le graphique
        document.getElementById('chartDay').addEventListener('click', function() {
            document.querySelectorAll('[id^="chart"]').forEach(btn => {
                btn.classList.remove('bg-blue-100', 'text-blue-700');
                btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            });
            this.classList.add('bg-blue-100', 'text-blue-700');
            this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            // Ici, vous pouvez recharger les données pour la période sélectionnée
        });
        
        document.getElementById('chartWeek').addEventListener('click', function() {
            document.querySelectorAll('[id^="chart"]').forEach(btn => {
                btn.classList.remove('bg-blue-100', 'text-blue-700');
                btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            });
            this.classList.add('bg-blue-100', 'text-blue-700');
            this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
        });
        
        document.getElementById('chartMonth').addEventListener('click', function() {
            document.querySelectorAll('[id^="chart"]').forEach(btn => {
                btn.classList.remove('bg-blue-100', 'text-blue-700');
                btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            });
            this.classList.add('bg-blue-100', 'text-blue-700');
            this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
        });

        // Chargement initial
        setTimeout(() => {
            fetchPredictions();
        }, 1000);
    </script>
</body>
</html>