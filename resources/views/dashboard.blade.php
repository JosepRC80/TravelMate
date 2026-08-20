<x-app-layout>

    <x-slot name="header">
        <x-page-header title="Inici">
            <x-slot:actions>
                <a href="{{ route('trips.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nou viatge
                </a>
            </x-slot:actions>
        </x-page-header>
    </x-slot>

    <div class="container py-4">

        <x-flash-message />

        <x-card class="mb-4 overflow-hidden">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="tm-section-label">
                        El teu espai de viatges
                    </span>

                    <h2 class="display-6 fw-bold mt-2 mb-3">
                        Benvingut/da, {{ Auth::user()->name }}
                    </h2>

                    <p class="text-muted fs-5 mb-4">
                        Organitza els teus viatges, desa llocs d'interès
                        i mantén tota la informació important en un sol lloc.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('trips.index') }}" class="btn btn-primary">
                            <i class="bi bi-map me-2"></i>
                            Veure els meus viatges
                        </a>

                        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-tags me-2"></i>
                            Gestionar categories
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 d-none d-lg-block text-center">
                    <div class="mx-auto d-flex align-items-center justify-content-center"
                        style="
                            width: 190px;
                            height: 190px;
                            border-radius: 50%;
                            background:
                                linear-gradient(
                                    135deg,
                                    rgba(30, 111, 217, 0.12),
                                    rgba(30, 111, 217, 0.03)
                                );
                        ">
                        <i class="bi bi-airplane-engines"
                            style="
                                font-size: 5rem;
                                color: var(--tm-primary);
                                transform: rotate(-18deg);
                            "></i>
                    </div>
                </div>
            </div>
        </x-card>

        <div class="row g-4">
            <div class="col-md-4">
                <x-card class="h-100">
                    <div class="d-flex align-items-start gap-3">
                        <span class="tm-icon-circle">
                            <i class="bi bi-map"></i>
                        </span>

                        <div>
                            <h3 class="h5 fw-bold mb-2">
                                Planifica viatges
                            </h3>

                            <p class="text-muted mb-0">
                                Crea itineraris i centralitza la informació
                                principal de cada viatge.
                            </p>
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="col-md-4">
                <x-card class="h-100">
                    <div class="d-flex align-items-start gap-3">
                        <span class="tm-icon-circle">
                            <i class="bi bi-geo-alt"></i>
                        </span>

                        <div>
                            <h3 class="h5 fw-bold mb-2">
                                Desa llocs
                            </h3>

                            <p class="text-muted mb-0">
                                Organitza els llocs d'interès i visualitza'ls
                                sobre el mapa.
                            </p>
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="col-md-4">
                <x-card class="h-100">
                    <div class="d-flex align-items-start gap-3">
                        <span class="tm-icon-circle">
                            <i class="bi bi-journal-text"></i>
                        </span>

                        <div>
                            <h3 class="h5 fw-bold mb-2">
                                Afegeix notes
                            </h3>

                            <p class="text-muted mb-0">
                                Guarda recordatoris, idees i informació útil
                                relacionada amb el viatge.
                            </p>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>

    </div>

</x-app-layout>
