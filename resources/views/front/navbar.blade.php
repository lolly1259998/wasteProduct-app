<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ url('/') }}">🌿 Waste2Product</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="bi bi-house-door me-1"></i>Home
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/products') }}" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                        <i class="bi bi-bag-check me-1"></i>Products
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/campaigns') }}" class="nav-link {{ request()->is('campaigns*') ? 'active' : '' }}">
                        <i class="bi bi-megaphone me-1"></i>Campaigns
                    </a>
                </li>

                <!-- Nouveau lien Waste Categories -->
                <li class="nav-item">
                    <a href="{{ route('front.waste-categories.index') }}" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
                        <i class="bi bi-grid-3x3-gap me-1"></i>Waste Categories
                    </a>
                </li>

                <!-- Nouveau lien Wastes -->
                <li class="nav-item">
                    <a href="{{ route('front.wastes.index') }}" class="nav-link {{ request()->is('wastess*') ? 'active' : '' }}">
                        <i class="bi bi-trash me-1"></i>Waste
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}">
                        <i class="bi bi-info-circle me-1"></i>About
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/contact') }}" class="nav-link {{ request()->is('contact') ? 'active' : '' }}">
                        <i class="bi bi-envelope me-1"></i>Contact
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/login') }}" class="nav-link text-light">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
