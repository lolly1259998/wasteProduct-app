<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste2Product - {{ $title ?? 'Home' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh; /* occupe toute la hauteur de l'écran */
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1; /* pousse le footer vers le bas */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">Waste2Product</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="{{ url('/products') }}" class="nav-link">Products</a></li>
                    <li class="nav-item"><a href="{{ url('/recycling') }}" class="nav-link">Recycling</a></li>
                    <li class="nav-item"><a href="{{ url('/donations') }}" class="nav-link">Donations</a></li>
                    <li class="nav-item"><a href="{{ url('/waste2product/collectionpoints') }}" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">Points de collecte</a></li>


                    <li class="nav-item"><a href="{{ route('front.wastes.index') }}" class="nav-link">Wastes</a></li>
                  <li class="nav-item"><a href="{{ url('/categories') }}" class="nav-link">Waste Categories</a></li>>
                     <li class="nav-item"><a href="{{ url('/contact') }}" class="nav-link">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="container py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-4">
        <p class="mb-0">© {{ date('Y') }} Waste2Product. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
