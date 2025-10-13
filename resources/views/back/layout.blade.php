<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
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
            </div>
            
            
        
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

</body>
</html>