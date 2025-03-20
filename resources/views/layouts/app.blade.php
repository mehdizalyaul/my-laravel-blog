<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

  <!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="/">Blog</a>

        <!-- Navbar Toggler (for mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="d-flex align-items-center ms-3">
            <input type="text" class="form-control me-2 search_input" placeholder="Rechercher un article...">
            <button class="btn btn-outline-primary" id="search_button">Rechercher</button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/posts">Articles</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="/categories">Categories</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link">Déconnexion</button>
                    </form>
                </li>
                @if(auth()->user()->image)
                <img src="{{ asset('storage/' . auth()->user()->image) }}" class="rounded-circle profile_image" alt="" >
            @else
                <img src="{{ asset('storage/profile_images/default_profile.png') }}" class="rounded-circle profile_image" alt="" >
            @endif
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Registre</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>


    <!-- Main Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Blog, All Rights Reserved. | <a href="#">Privacy Policy</a></p>
    </footer>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/posts/header.js','resources/css/app.css'])

</body>
</html>
