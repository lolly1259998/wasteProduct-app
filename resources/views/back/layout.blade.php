<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office - Waste2Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
            <h4 class="mb-4">Admin</h4>
            <ul class="nav flex-column">
    <li class="nav-item mb-2">
        <a href="{{ url('back/home') }}" class="nav-link text-white">Dashboard</a>
    </li>
    <li class="nav-item mb-2">
        <a href="#" class="nav-link text-white">Waste Management</a>
    </li>
    <li class="nav-item mb-2">
        <a href="#" class="nav-link text-white">Catégories</a>
    </li>
</ul>

        </div>

        <!-- Main content -->
        <div class="p-4 w-100">
            @yield('content')
        </div>
    </div>
</body>
</html>
