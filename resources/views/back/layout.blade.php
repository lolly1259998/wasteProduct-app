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
    /* Toggle button */
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
    /* Cards */
    /* Card style */
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
                <button class="btn btn-sm btn-light toggle-btn" id="toggleSidebar" aria-label="Toggle sidebar"><i class="bi bi-list"></i></button>
            </div>
            <ul class="nav flex-column" role="navigation">
                <li class="nav-item mb-2">
                    <a href="{{ url('back/home') }}" class="nav-link {{ request()->routeIs('back.home') ? 'active' : '' }}" data-tooltip="Dashboard" aria-label="Dashboard"><i class="bi bi-speedometer2 me-2"></i> <span class="nav-text">Dashboard</span></a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('back.donations.index') }}" class="nav-link {{ request()->routeIs('back.donations.*') ? 'active' : '' }}" data-tooltip="Donations" aria-label="Donations"><i class="bi bi-heart-fill me-2"></i> <span class="nav-text">Donations</span></a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('back.orders.index') }}" class="nav-link {{ request()->routeIs('back.orders.*') ? 'active' : '' }}" data-tooltip="Orders" aria-label="Orders"><i class="bi bi-cart me-2"></i> <span class="nav-text">Orders</span></a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('back.reservations.index') }}" class="nav-link {{ request()->routeIs('back.reservations.*') ? 'active' : '' }}" data-tooltip="Reservations" aria-label="Reservations"><i class="bi bi-calendar-check me-2"></i> <span class="nav-text">Reservations</span></a>
                </li>
            </ul>
        </div>
        <!-- Main content -->
        <div class="main-content" id="mainContent">
            <!-- Header -->
            <div class="header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
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
        // Keyboard navigation for accessibility
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    window.location.href = link.getAttribute('href');
                }
            });
        });
    </script>
</body>
</html>