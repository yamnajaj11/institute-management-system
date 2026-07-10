<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand custom-border px-3 py-1 rounded" href="#">{{ __('navbar.institute_name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link custom-border px-3 py-1 rounded {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        {{ __('navbar.home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link custom-border px-3 py-1 rounded {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        {{ __('navbar.about') }}
                    </a>
                </li>
            </ul>
            <div class="d-flex">
                <a href="{{ route('login') }}" class="btn btn-outline-light custom-border px-3 py-1 rounded">{{ __('navbar.login') }}</a>
            </div>
        </div>
    </div>
</nav>
