<nav x-data="{ open: false }" class="tm-navbar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between" style="min-height: 64px;">

            <div class="d-flex align-items-center gap-4">
                <a href="{{ route('dashboard') }}" class="tm-brand">
                    <span class="tm-brand-icon">
                        <i class="bi bi-compass-fill"></i>
                    </span>

                    <span>TravelMate</span>
                </a>

                <div class="d-none d-md-flex align-items-center gap-1">
                    <a href="{{ route('dashboard') }}" @class([
                        'tm-nav-link',
                        'is-active' => request()->routeIs('dashboard'),
                    ])>
                        <i class="bi bi-house-door"></i>
                        Inici
                    </a>

                    <a href="{{ route('trips.index') }}" @class([
                        'tm-nav-link',
                        'is-active' =>
                            request()->routeIs('trips.*') ||
                            request()->routeIs('places.*') ||
                            request()->routeIs('notes.*'),
                    ])>
                        <i class="bi bi-map"></i>
                        Els meus viatges
                    </a>

                    <a href="{{ route('categories.index') }}" @class([
                        'tm-nav-link',
                        'is-active' => request()->routeIs('categories.*'),
                    ])>
                        <i class="bi bi-tags"></i>
                        Categories
                    </a>
                </div>
            </div>

            <div class="d-none d-md-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="tm-icon-circle" style="width: 32px; height: 32px;">
                            <i class="bi bi-person"></i>
                        </span>

                        <span>{{ Auth::user()->name }}</span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="bi bi-person-gear me-2"></i>
                                Perfil
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Tancar sessió
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <button type="button" class="btn btn-light d-md-none" @click="open = ! open" aria-label="Obrir navegació">
                <i class="bi" :class="open ? 'bi-x-lg' : 'bi-list'"></i>
            </button>
        </div>

        <div x-show="open" x-transition class="d-md-none pb-3">
            <div class="d-flex flex-column gap-1">
                <a href="{{ route('dashboard') }}" @class([
                    'tm-nav-link',
                    'is-active' => request()->routeIs('dashboard'),
                ])>
                    <i class="bi bi-house-door"></i>
                    Inici
                </a>

                <a href="{{ route('trips.index') }}" @class([
                    'tm-nav-link',
                    'is-active' =>
                        request()->routeIs('trips.*') ||
                        request()->routeIs('places.*') ||
                        request()->routeIs('notes.*'),
                ])>
                    <i class="bi bi-map"></i>
                    Els meus viatges
                </a>

                <a href="{{ route('categories.index') }}" @class([
                    'tm-nav-link',
                    'is-active' => request()->routeIs('categories.*'),
                ])>
                    <i class="bi bi-tags"></i>
                    Categories
                </a>

                <a href="{{ route('profile.edit') }}" class="tm-nav-link">
                    <i class="bi bi-person-gear"></i>
                    Perfil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="tm-nav-link border-0 bg-transparent text-danger w-100">
                        <i class="bi bi-box-arrow-right"></i>
                        Tancar sessió
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
