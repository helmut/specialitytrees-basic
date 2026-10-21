<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Speciality Trees') — Speciality Trees</title>
    <meta name="description" content="@yield('description', 'Specialists in the environmentally sustainable production of premium quality advanced landscaping trees and screens.')">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

{{-- Top nav --}}
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.jpg') }}" alt="Speciality Trees" style="height:40px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('trees*') ? 'active' : '' }}" href="{{ url('/trees') }}">Trees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('collections*') ? 'active' : '' }}" href="{{ url('/collections') }}">Collections</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('blog*') ? 'active' : '' }}" href="{{ url('/blog') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about*') ? 'active' : '' }}" href="{{ url('/about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contact*') ? 'active' : '' }}" href="{{ url('/contact') }}">Contact</a>
                </li>
            </ul>
            <a href="{{ url('/trees') }}" class="text-white ms-2"><i class="fas fa-search"></i></a>
        </div>
    </div>
</nav>

@yield('content')

{{-- Footer --}}
<footer class="bg-dark text-white mt-5 pt-5 pb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h6 class="text-uppercase fw-bold mb-3">Trees</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ url('/trees') }}" class="text-white-50">Search</a></li>
                    <li><a href="{{ url('/collections') }}" class="text-white-50">Collections</a></li>
                    <li><a href="{{ url('/trees/families') }}" class="text-white-50">Families</a></li>
                    <li><a href="{{ url('/trees/genus') }}" class="text-white-50">Genus</a></li>
                    <li><a href="{{ url('/trees/species') }}" class="text-white-50">Species</a></li>
                    <li><a href="{{ url('/trees/categories') }}" class="text-white-50">Categories</a></li>
                    <li><a href="{{ url('/trees/heights') }}" class="text-white-50">Mature Height</a></li>
                    <li><a href="{{ url('/trees/forms') }}" class="text-white-50">Forms</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-uppercase fw-bold mb-3">Company</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ url('/about') }}" class="text-white-50">About Us</a></li>
                    <li><a href="{{ url('/about/team') }}" class="text-white-50">Meet the Team</a></li>
                    <li><a href="{{ url('/about/contract-growing') }}" class="text-white-50">Contract Growing</a></li>
                    <li><a href="{{ url('/about/standards') }}" class="text-white-50">Our Standards</a></li>
                    <li><a href="{{ url('/about/sponsors') }}" class="text-white-50">Sponsors</a></li>
                    <li><a href="{{ url('/councils') }}" class="text-white-50">Councils</a></li>
                    <li><a href="{{ url('/blog') }}" class="text-white-50">Blog</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-white-50">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-uppercase fw-bold mb-3">Legal</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ url('/terms') }}" class="text-white-50">Terms &amp; Conditions</a></li>
                    <li><a href="{{ url('/privacy') }}" class="text-white-50">Privacy Policy</a></li>
                    <li><a href="{{ url('/disclaimer') }}" class="text-white-50">Disclaimer</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-uppercase fw-bold mb-3">Contact</h6>
                <p class="small text-white-50">
                    Speciality Trees Pty Ltd<br>
                    <a href="{{ url('/contact') }}" class="text-white-50">Get in touch</a>
                </p>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="d-flex justify-content-between align-items-center small text-white-50">
            <span>&copy; {{ date('Y') }} Speciality Trees Pty Ltd. All Rights Reserved.</span>
            <span>Design by <a href="http://helmutdesign.com.au" class="text-white-50">Helmut Design</a></span>
        </div>
        <p class="small text-white-50 mt-2">
            <em>Speciality Trees acknowledges the traditional custodians of the lands where we live, learn and work.</em>
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@stack('scripts')
</body>
</html>
