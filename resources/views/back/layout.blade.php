<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Back Office - Waste2Product</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        transition: all 0.3s;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        min-height: 100vh;
        background: linear-gradient(180deg, #003d39ff 0%, #000b0aff 100%);
        transition: width 0.3s ease;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1100;
        box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2);
    }
    .sidebar.collapsed { width: 70px; }

    .sidebar .nav-link {
        color: #e6f4f3;
        padding: 12px 15px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        transition: background-color 0.3s, transform 0.2s, padding 0.3s;
        position: relative;
        font-size: 1rem;
        font-weight: 500;
    }
    .sidebar .nav-link:hover, .sidebar .nav-link.active {
        background-color: rgba(255, 255, 255, 0.1);
        transform: scale(1.02);
    }

    .sidebar .nav-text {
        transition: opacity 0.3s, display 0.3s;
        margin-left: 12px;
    }
    .sidebar.collapsed .nav-text {
        opacity: 0;
        display: none;
    }

    .sidebar .nav-item .submenu {
        display: none;
        list-style: none;
        padding-left: 30px;
        background-color: rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        margin: 8px 0;
    }
    .sidebar .nav-item.show .submenu {
        display: block;
    }
    .sidebar .submenu .nav-link {
        font-size: 0.875rem;
        padding: 8px 15px;
        color: #d1e8e6;
    }
    .sidebar .submenu .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    /* Tooltip */
    .sidebar.collapsed .nav-link::after {
        content: attr(data-tooltip);
        position: absolute;
        left: 80px;
        background-color: #0d403d;
        color: #e6f4f3;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.875rem;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease-in-out;
        z-index: 1200;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    .sidebar.collapsed .nav-link:hover::after {
        opacity: 1;
    }

    /* Toggle button */
    .sidebar .toggle-btn {
        transition: transform 0.3s ease, background-color 0.3s;
        background-color: #2aa198;
        border: none;
    }
    .sidebar .toggle-btn:hover {
        background-color: #3cb8ae;
    }
    .sidebar.collapsed .toggle-btn {
        transform: rotate(180deg);
    }

    /* Main content */
    .main-content {
        margin-left: 250px;
        width: calc(100% - 250px);
        transition: all 0.3s;
    }
    .main-content.collapsed {
        margin-left: 70px;
        width: calc(100% - 70px);
    }

    /* Header */
    .header {
        background-color: #fff;
        padding: 0.5rem 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    /* Cards */
    .card {
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .card:hover { transform: translateY(-5px); }

    @media (max-width: 768px) {
        .sidebar {
            width: 70px;
        }
        .main-content {
            margin-left: 70px;
            width: calc(100% - 70px);
        }
        .sidebar .nav-text {
            opacity: 0;
            display: none;
        }
        .sidebar.collapsed .nav-link::after {
            display: none;
        }
        .sidebar .submenu {
            padding-left: 15px;
        }
    }
</style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3" id="sidebar">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-white mb-0 nav-text">🌿 Waste2Product</h4>
            <button class="btn btn-sm btn-light toggle-btn" id="toggleSidebarBtn" aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <ul class="nav flex-column" role="navigation">
            <li class="nav-item mb-2">
                <a href="{{ url('back/home') }}" class="nav-link" data-tooltip="Dashboard" aria-label="Dashboard">
                    <i class="bi bi-speedometer2 me-2"></i> <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="#wasteSubmenu" class="nav-link" onclick="toggleSubmenu(event)" data-tooltip="Waste Management" aria-label="Waste Management">
                    <i class="bi bi-trash3 me-2"></i> <span class="nav-text">Waste Management</span>
                </a>
                <ul class="submenu list-unstyled" id="wasteSubmenu">
                    <li><a href="#" class="nav-link text-white" data-tooltip="All Waste">All Waste</a></li>
                    <li><a href="#" class="nav-link text-white" data-tooltip="Add Waste">Add Waste</a></li>
                </ul>
            </li>

            <li class="nav-item mb-2">
                <a href="#" class="nav-link" data-tooltip="Catégories" aria-label="Catégories">
                    <i class="bi bi-tags me-2"></i> <span class="nav-text">Catégories</span>
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('back.campaigns') }}" class="nav-link" data-tooltip="Campaign Management" aria-label="Campaign Management">
                    <i class="bi bi-megaphone me-2"></i> <span class="nav-text">Campaign Management</span>
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ url('/predictwaste') }}" class="nav-link {{ request()->is('predictwaste') ? 'active' : '' }}">
                    <i class="bi bi-robot me-2"></i> <span class="nav-text">AI Waste Prediction</span>
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ url('/ai-advice') }}" class="nav-link {{ request()->is('ai-advice') ? 'active' : '' }}">
                    <i class="bi bi-lightbulb me-2"></i> <span class="nav-text">Smart Waste Tips</span>
                </a>
            </li>

             <li class="nav-item mb-2">
                <a href="{{ url('/dashbored/collectionpoints') }}" class="nav-link {{ request()->is('collectionpoints/index') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt me-2"></i> <span class="nav-text">collectionpoints</span>
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ url('/collectionpoints/predictions') }}" class="nav-link {{ request()->is('collectionpoints/predictions') ? 'active' : '' }}">
                    <i class="bi bi-cpu me-1"></i> <span class="nav-text">IA Points de Collecte</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="main-content" id="mainContent">
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Dashboard</h5>
            <div class="d-flex align-items-center">
                <input type="text" class="form-control form-control-sm me-2" placeholder="Search..." aria-label="Search">
                <i class="bi bi-bell fs-4 me-3" aria-label="Notifications"></i>
                <i class="bi bi-person-circle fs-4" aria-label="User Profile"></i>
            </div>
        </div>

        <div class="p-4">
            @yield('content')
        </div>
    </div>
</div>

<script>
    // ✅ Noms de variables uniques pour éviter le conflit
    const sidebarEl = document.getElementById('sidebar');
    const mainContentEl = document.getElementById('mainContent');
    const toggleSidebarBtnEl = document.getElementById('toggleSidebarBtn');

    // Toggle sidebar
    toggleSidebarBtnEl.addEventListener('click', () => {
        sidebarEl.classList.toggle('collapsed');
        mainContentEl.classList.toggle('collapsed');
        const isExpanded = !sidebarEl.classList.contains('collapsed');
        toggleSidebarBtnEl.setAttribute('aria-expanded', isExpanded);
    });

    // Toggle submenu
    function toggleSubmenu(e) {
        e.preventDefault();
        const parent = e.target.closest('.nav-item');
        const isCollapsed = sidebarEl.classList.contains('collapsed');
        const submenu = parent.querySelector('.submenu');
        const isOpen = parent.classList.contains('show');

        document.querySelectorAll('.nav-item.show').forEach(item => {
            if (item !== parent) item.classList.remove('show');
        });

        parent.classList.toggle('show');

        if (isCollapsed && !isOpen) {
            sidebarEl.classList.remove('collapsed');
            mainContentEl.classList.remove('collapsed');
            toggleSidebarBtnEl.setAttribute('aria-expanded', true);
        }

        const link = parent.querySelector('.nav-link');
        link.setAttribute('aria-expanded', !isOpen);
    }

    // Keyboard accessibility
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        link.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                if (link.getAttribute('href') === '#') {
                    toggleSubmenu(e);
                } else {
                    window.location.href = link.getAttribute('href');
                }
            }
        });
    });
</script>
</body>
</html>
