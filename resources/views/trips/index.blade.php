<x-app-layout>

    <x-slot name="header">
        <x-page-header title="Els meus viatges">
            <x-slot:subtitle>
                Consulta i gestiona tots els teus viatges.
            </x-slot:subtitle>

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

        @if ($trips->isEmpty())
            <x-card>
                <x-empty-state title="Encara no tens cap viatge"
                    description="Crea el teu primer viatge i comença a planificar els llocs que vols visitar."
                    icon="bi-airplane">
                    <x-slot:action>
                        <a href="{{ route('trips.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i>
                            Crear el primer viatge
                        </a>
                    </x-slot:action>
                </x-empty-state>
            </x-card>
        @else
            <div class="row g-4">
                @foreach ($trips as $trip)
                    <div class="col-12 col-md-6 col-xl-4">
                        <x-card class="h-100">
                            <div class="d-flex flex-column h-100">

                                <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="tm-icon-circle">
                                            <i class="bi bi-airplane"></i>
                                        </span>

                                        <div>
                                            <span class="tm-section-label">
                                                Viatge
                                            </span>

                                            <h2 class="h5 fw-bold mb-0 mt-1">
                                                {{ $trip->title }}
                                            </h2>
                                        </div>
                                    </div>

                                    <span class="badge rounded-pill text-bg-light border">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ $trip->country }}
                                    </span>
                                </div>

                                <p class="text-muted mb-4">
                                    {{ $trip->description
                                        ? \Illuminate\Support\Str::limit($trip->description, 125)
                                        : 'Aquest viatge encara no té cap descripció.' }}
                                </p>

                                <div class="mt-auto">
                                    <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                                        <i class="bi bi-calendar-event"></i>

                                        <span>
                                            {{ $trip->start_date->format('d/m/Y') }}
                                            —
                                            {{ $trip->end_date->format('d/m/Y') }}
                                        </span>
                                    </div>

                                    <hr class="my-3">

                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('trips.show', $trip) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i>
                                            Veure
                                        </a>

                                        <a href="{{ route('trips.edit', $trip) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil me-1"></i>
                                            Editar
                                        </a>

                                        <form action="{{ route('trips.destroy', $trip) }}" method="POST"
                                            class="ms-sm-auto"
                                            onsubmit="return confirm('Segur que vols eliminar aquest viatge? També s’eliminaran els seus llocs i notes.');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash me-1"></i>
                                                Esborrar
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </x-card>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

</x-app-layout>
