<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office - Waste2Product</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/@heroicons/vue@2.0.13/outline.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh; position: fixed;">
            <h4 class="mb-4">Admin</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('back.home') }}" class="nav-link text-white">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('waste_categories.index') }}" class="nav-link text-white">waste_categories</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('wastes.index') }}" class="nav-link text-white">wastes</a>
                </li>
                <li class="nav-item mb-2">
            <a href="{{ url('/predictwaste') }}" class="nav-link text-white">AI Waste Prediction</a>
        </li>
            </ul>
        </div>

        <!-- Main content -->
       <div class="p-4" style="margin-left: 250px; width: calc(100% - 250px); min-height: 100vh;">
            @yield('content')
    </div>
</body>
</html>
