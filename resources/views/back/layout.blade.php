<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
<<<<<<< Updated upstream
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office - Waste2Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
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
        .sidebar-overlay.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        
<body class="h-100">
  <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <a href="{{ route('back.home') }}" class="brand">
                <div class="brand-logo">
                    <i class="bi bi-recycle"></i>
                </div>
                <div>
                    <div class="brand-text">Waste2Product</div>
                    <small class="text-muted">Administration</small>
                </div>
            </a>
        </div>
        
        <!-- Navigation -->
        <nav class="sidebar-nav">
            <!-- Main Section -->
            <div class="nav-section">
                <div class="nav-section-title">Navigation Principale</div>
                <div class="nav-item">
                    <a href="{{ route('back.home') }}" 
                       class="nav-link {{ request()->routeIs('back.home') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="bi bi-speedometer2"></i>
                        </div>
                        <span>Tableau de Bord</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('collectionpoints.index') }}" 
                       class="nav-link {{ request()->routeIs('collectionpoints.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="bi bi-pin-map"></i>
                        </div>
                        <span>Points de Collecte</span>
                        
                    </a>
                </div>
                 <!-- Waste Categories -->
        <div class="nav-item">
            <a href="{{ route('waste_categories.index') }}" 
               class="nav-link {{ request()->routeIs('waste_categories.*') ? 'active' : '' }}">
                <div class="nav-icon">
                    <i class="bi bi-card-list"></i>
                </div>
                <span>Waste Categories</span>
            </a>
        </div>

        <!-- Wastes -->
        <div class="nav-item">
            <a href="{{ route('wastes.index') }}" 
               class="nav-link {{ request()->routeIs('wastes.*') ? 'active' : '' }}">
                <div class="nav-icon">
                    <i class="bi bi-trash"></i>
                </div>
                <span>Wastes</span>
            </a>
        </div>

        <!-- AI Waste Prediction -->
        <div class="nav-item">
            <a href="{{ url('/predictwaste') }}" 
               class="nav-link {{ request()->is('predictwaste') ? 'active' : '' }}">
                <div class="nav-icon">
                    <i class="bi bi-robot"></i>
                </div>
                <span>AI Waste Prediction</span>
            </a>
        </div>

        <!-- Smart Waste Tips -->
        <div class="nav-item">
            <a href="{{ url('/ai-advice') }}" 
               class="nav-link {{ request()->is('ai-advice') ? 'active' : '' }}">
                <div class="nav-icon">
                    <i class="bi bi-lightbulb"></i>
                </div>
                <span>Smart Waste Tips</span>
            </a>
        </div>
        
    </div>

        </nav>
        <!-- Sidebar Footer -->
        <div class="position-absolute bottom-0 start-0 end-0 p-3 border-top border-dark">
            <div class="d-flex align-items-center gap-3">
                <div class="flex-shrink-0">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 40px; height: 40px;">
                        <i class="bi bi-person-fill text-white"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="text-white fw-medium">Admin User</div>
                    <small class="text-muted">Administrateur</small>
                </div>
                <a href="#" class="text-muted">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="p-4">
            @yield('content')
        </div>
    </div>

=======
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
    .sidebar.collapsed {
        width: 70px;
    }
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
    /* Tooltips for collapsed state */
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
    /* Toggle button animation */
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

    /* Card style */
    .card {
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }

    /* Responsive adjustments */
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
                <button class="btn btn-sm btn-light toggle-btn" id="toggleSidebar" aria-label="Toggle sidebar"><i class="bi bi-list"></i></button>
            </div>
            <ul class="nav flex-column" role="navigation">
                <li class="nav-item mb-2">
                    <a href="{{ url('back/home') }}" class="nav-link" data-tooltip="Dashboard" aria-label="Dashboard"><i class="bi bi-speedometer2 me-2"></i> <span class="nav-text">Dashboard</span></a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#wasteSubmenu" class="nav-link" onclick="toggleSubmenu(event)" data-tooltip="Waste Management" aria-label="Waste Management"><i class="bi bi-trash3 me-2"></i> <span class="nav-text">Waste Management</span></a>
                    <ul class="submenu list-unstyled" id="wasteSubmenu">
                        <li><a href="#" class="nav-link text-white" data-tooltip="All Waste">All Waste</a></li>
                        <li><a href="#" class="nav-link text-white" data-tooltip="Add Waste">Add Waste</a></li>
                    </ul>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link" data-tooltip="Catégories" aria-label="Catégories"><i class="bi bi-tags me-2"></i> <span class="nav-text">Catégories</span></a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('back.campaigns') }}" class="nav-link" data-tooltip="Campaign Management" aria-label="Campaign Management"><i class="bi bi-megaphone me-2"></i> <span class="nav-text">Campaign Management</span></a>
                </li>
            </ul>
        </div>

        <!-- Main content -->
        <div class="main-content" id="mainContent">
            <!-- Header -->
            <div class="header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Dashboard</h5>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control form-control-sm me-2" placeholder="Search..." aria-label="Search">
                    <i class="bi bi-bell fs-4 me-3" aria-label="Notifications"></i>
                    <i class="bi bi-person-circle fs-4" aria-label="User Profile"></i>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleSidebarBtn = document.getElementById('toggleSidebar');

        // Toggle sidebar
        toggleSidebarBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
            // Update aria-expanded for accessibility
            const isExpanded = !sidebar.classList.contains('collapsed');
            toggleSidebarBtn.setAttribute('aria-expanded', isExpanded);
        });

        // Toggle submenu
        function toggleSubmenu(e) {
            e.preventDefault();
            const parent = e.target.closest('.nav-item');
            const isCollapsed = sidebar.classList.contains('collapsed');
            const submenu = parent.querySelector('.submenu');
            const isOpen = parent.classList.contains('show');

            // Close all other submenus
            document.querySelectorAll('.nav-item.show').forEach(item => {
                if (item !== parent) item.classList.remove('show');
            });

            // Toggle the submenu
            parent.classList.toggle('show');

            // If sidebar is collapsed, temporarily expand it to show submenu
            if (isCollapsed && !isOpen) {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('collapsed');
                toggleSidebarBtn.setAttribute('aria-expanded', true);
            }

            // Update aria-expanded for accessibility
            const link = parent.querySelector('.nav-link');
            link.setAttribute('aria-expanded', !isOpen);
        }

        // Keyboard navigation for accessibility
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
>>>>>>> Stashed changes
</body>
</html>