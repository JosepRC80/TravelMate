<x-app-layout>

    <x-slot name="header">
        <x-page-header :title="$trip->title" :back-route="route('trips.index')" back-text="Els meus viatges">
            <x-slot:subtitle>
                Consulta els llocs, el mapa i les notes del viatge.
            </x-slot:subtitle>

            <x-slot:actions>
                <a href="{{ route('trips.edit', $trip) }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-pencil me-1"></i>
                    Editar
                </a>
            </x-slot:actions>
        </x-page-header>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        #trip-map {
            width: 100%;
            height: 430px;
            position: relative;
            overflow: hidden;
            border-radius: 14px;
            z-index: 1;
        }

        #trip-map img,
        .leaflet-container img,
        .leaflet-tile {
            max-width: none !important;
            max-height: none !important;
        }

        .leaflet-container {
            width: 100%;
            height: 100%;
            font-family: inherit;
            background: #e5e7eb;
        }

        .leaflet-control-container {
            position: relative;
            z-index: 800;
        }

        .trip-hero {
            position: relative;
            overflow: hidden;
        }

        .trip-hero::after {
            content: "";
            position: absolute;
            top: -90px;
            right: -90px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(30, 111, 217, 0.07);
            pointer-events: none;
        }

        .trip-stat {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 0;
        }

        .trip-illustration {
            width: 155px;
            height: 155px;
            border-radius: 50%;
            background: linear-gradient(135deg,
                    rgba(30, 111, 217, 0.13),
                    rgba(30, 111, 217, 0.03));
        }

        .place-card,
        .note-card {
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .place-card:hover,
        .note-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 32px rgba(23, 32, 51, 0.1) !important;
        }

        .place-card-header {
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }

        .place-category {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.75rem;
            border-radius: 999px;
            color: var(--tm-primary);
            background: rgba(30, 111, 217, 0.09);
            font-size: 0.78rem;
            font-weight: 600;
        }

        .place-status {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.7rem;
            border-radius: 999px;
            font-size: 0.76rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .place-status-visited {
            color: #157347;
            background: rgba(25, 135, 84, 0.11);
        }

        .place-status-pending {
            color: #6c757d;
            background: rgba(108, 117, 125, 0.11);
        }

        .place-description {
            line-height: 1.7;
        }

        .place-coordinate-box {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.7rem 0.85rem;
            border-radius: 12px;
            color: #64748b;
            background: #f8fafc;
            font-size: 0.8rem;
            overflow-wrap: anywhere;
        }

        .place-actions {
            padding-top: 1rem;
            margin-top: auto;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
        }

        @media (max-width: 575.98px) {
            #trip-map {
                height: 350px;
            }

            .place-actions .btn,
            .place-actions form {
                width: 100%;
            }

            .place-actions form .btn {
                width: 100%;
            }
        }
    </style>

    @php
        $placesWithCoordinates = $trip->places->whereNotNull('latitude')->whereNotNull('longitude')->values();

        $mapPlaces = $placesWithCoordinates
            ->map(function ($place) {
                return [
                    'name' => $place->name,
                    'country' => $place->country,
                    'latitude' => $place->latitude,
                    'longitude' => $place->longitude,
                    'visited' => (bool) $place->visited,
                    'category' => optional($place->category)->name ?? 'Sense categoria',
                ];
            })
            ->values();

        $visitedPlaces = $trip->places->where('visited', true)->count();

        $pendingPlaces = $trip->places->where('visited', false)->count();
    @endphp

    <div class="container py-4">

        <x-flash-message />

        {{-- Informació principal --}}
        <x-card class="trip-hero mb-4">
            <div class="position-relative" style="z-index: 2;">
                <div class="row align-items-center g-4">
                    <div class="col-lg-9">
                        <span class="tm-section-label">
                            Informació del viatge
                        </span>

                        <h2 class="display-6 fw-bold mt-2 mb-3">
                            {{ $trip->title }}
                        </h2>

                        @if ($trip->description)
                            <p class="text-muted fs-5 mb-4">
                                {{ $trip->description }}
                            </p>
                        @else
                            <p class="text-muted fs-5 fst-italic mb-4">
                                Aquest viatge encara no té cap descripció.
                            </p>
                        @endif

                        <div class="row g-3">
                            <div class="col-sm-6 col-xl-4">
                                <div class="trip-stat">
                                    <span class="tm-icon-circle">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>

                                    <div>
                                        <div class="small text-muted">
                                            Destinació
                                        </div>

                                        <div class="fw-semibold">
                                            {{ $trip->country }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-4">
                                <div class="trip-stat">
                                    <span class="tm-icon-circle">
                                        <i class="bi bi-calendar-event"></i>
                                    </span>

                                    <div>
                                        <div class="small text-muted">
                                            Dates
                                        </div>

                                        <div class="fw-semibold">
                                            {{ $trip->start_date->format('d/m/Y') }}
                                            —
                                            {{ $trip->end_date->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-4">
                                <div class="trip-stat">
                                    <span class="tm-icon-circle">
                                        <i class="bi bi-pin-map"></i>
                                    </span>

                                    <div>
                                        <div class="small text-muted">
                                            Llocs
                                        </div>

                                        <div class="fw-semibold">
                                            {{ $trip->places->count() }}
                                            registrats
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a href="{{ route('places.create', $trip) }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>
                                Afegir lloc
                            </a>

                            <a href="{{ route('notes.create', $trip) }}" class="btn btn-outline-primary">
                                <i class="bi bi-journal-plus me-1"></i>
                                Afegir nota
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 d-none d-lg-flex justify-content-center">
                        <div class="trip-illustration d-flex align-items-center justify-content-center">
                            <i class="bi bi-globe-europe-africa"
                                style="
                                    font-size: 4rem;
                                    color: var(--tm-primary);
                                "></i>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

        {{-- Resum --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <x-card class="h-100">
                    <div class="d-flex align-items-center gap-3">
                        <span class="tm-icon-circle">
                            <i class="bi bi-check-circle"></i>
                        </span>

                        <div>
                            <div class="small text-muted">
                                Llocs visitats
                            </div>

                            <div class="h4 fw-bold mb-0">
                                {{ $visitedPlaces }}
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="col-md-4">
                <x-card class="h-100">
                    <div class="d-flex align-items-center gap-3">
                        <span class="tm-icon-circle">
                            <i class="bi bi-clock-history"></i>
                        </span>

                        <div>
                            <div class="small text-muted">
                                Llocs pendents
                            </div>

                            <div class="h4 fw-bold mb-0">
                                {{ $pendingPlaces }}
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="col-md-4">
                <x-card class="h-100">
                    <div class="d-flex align-items-center gap-3">
                        <span class="tm-icon-circle">
                            <i class="bi bi-journal-text"></i>
                        </span>

                        <div>
                            <div class="small text-muted">
                                Notes
                            </div>

                            <div class="h4 fw-bold mb-0">
                                {{ $trip->notes->count() }}
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>

        {{-- Mapa --}}
        <x-card class="mb-5">
            <x-slot:header>
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                        <span class="tm-section-label">
                            Localització
                        </span>

                        <h2 class="h4 fw-bold mt-1 mb-0">
                            Mapa del viatge
                        </h2>
                    </div>

                    <span class="tm-icon-circle">
                        <i class="bi bi-map"></i>
                    </span>
                </div>
            </x-slot:header>

            @if ($placesWithCoordinates->isNotEmpty())
                <div id="trip-map"></div>
            @else
                <x-empty-state title="No hi ha llocs al mapa"
                    description="Afegeix coordenades als llocs del viatge per poder visualitzar-los." icon="bi-map">
                    <x-slot:action>
                        <a href="{{ route('places.create', $trip) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-1"></i>
                            Afegir lloc
                        </a>
                    </x-slot:action>
                </x-empty-state>
            @endif
        </x-card>

        {{-- Llocs --}}
        <section class="mb-5">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <span class="tm-section-label">
                        Itinerari
                    </span>

                    <h2 class="h3 fw-bold mt-1 mb-0">
                        Llocs del viatge
                    </h2>
                </div>

                <a href="{{ route('places.create', $trip) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>
                    Afegir lloc
                </a>
            </div>

            @if ($trip->places->isNotEmpty())
                <div class="row g-4">
                    @foreach ($trip->places as $place)
                        <div class="col-12 col-xl-6">
                            <x-card class="place-card h-100">
                                <div class="d-flex flex-column h-100">

                                    <div class="place-card-header mb-3">
                                        <div class="d-flex justify-content-between align-items-start gap-3">
                                            <div class="d-flex align-items-start gap-3">
                                                <span class="tm-icon-circle flex-shrink-0">
                                                    <i class="bi bi-geo-alt"></i>
                                                </span>

                                                <div>
                                                    <h3 class="h5 fw-bold mb-1">
                                                        {{ $place->name }}
                                                    </h3>

                                                    <div class="text-muted small">
                                                        <i class="bi bi-globe2 me-1"></i>
                                                        {{ $place->country }}
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($place->visited)
                                                <span class="place-status place-status-visited">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Visitat
                                                </span>
                                            @else
                                                <span class="place-status place-status-pending">
                                                    <i class="bi bi-clock"></i>
                                                    Pendent
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <span class="place-category">
                                            <i class="bi bi-tag"></i>

                                            {{ optional($place->category)->name ?? 'Sense categoria' }}
                                        </span>
                                    </div>

                                    @if ($place->description)
                                        <p class="place-description text-muted mb-3">
                                            {{ $place->description }}
                                        </p>
                                    @else
                                        <p class="place-description text-muted fst-italic mb-3">
                                            Aquest lloc encara no té cap descripció.
                                        </p>
                                    @endif

                                    @if (!is_null($place->latitude) && !is_null($place->longitude))
                                        <div class="place-coordinate-box mb-4">
                                            <i class="bi bi-crosshair"></i>

                                            <span>
                                                {{ $place->latitude }},
                                                {{ $place->longitude }}
                                            </span>
                                        </div>
                                    @endif

                                    <div class="place-actions d-flex flex-wrap align-items-center gap-2">
                                        <form action="{{ route('places.toggleVisited', [$trip, $place]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="btn {{ $place->visited ? 'btn-outline-secondary' : 'btn-outline-success' }} btn-sm">
                                                @if ($place->visited)
                                                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                                                    Marcar pendent
                                                @else
                                                    <i class="bi bi-check-lg me-1"></i>
                                                    Marcar visitat
                                                @endif
                                            </button>
                                        </form>

                                        <a href="{{ route('places.edit', [$trip, $place]) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil me-1"></i>
                                            Editar
                                        </a>

                                        @if (!is_null($place->latitude) && !is_null($place->longitude))
                                            <a href="https://www.google.com/maps?q={{ $place->latitude }},{{ $place->longitude }}"
                                                target="_blank" rel="noopener noreferrer"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-box-arrow-up-right me-1"></i>
                                                Google Maps
                                            </a>
                                        @endif

                                        <form action="{{ route('places.destroy', [$trip, $place]) }}" method="POST"
                                            class="ms-xl-auto"
                                            onsubmit="return confirm('Segur que vols esborrar aquest lloc?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash me-1"></i>
                                                Esborrar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </x-card>
                        </div>
                    @endforeach
                </div>
            @else
                <x-card>
                    <x-empty-state title="Aquest viatge encara no té llocs"
                        description="Afegeix els llocs que vols visitar durant el viatge." icon="bi-geo-alt">
                        <x-slot:action>
                            <a href="{{ route('places.create', $trip) }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>
                                Afegir el primer lloc
                            </a>
                        </x-slot:action>
                    </x-empty-state>
                </x-card>
            @endif
        </section>

        {{-- Notes --}}
        <section class="mb-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <span class="tm-section-label">
                        Informació addicional
                    </span>

                    <h2 class="h3 fw-bold mt-1 mb-0">
                        Notes del viatge
                    </h2>
                </div>

                <a href="{{ route('notes.create', $trip) }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-journal-plus me-1"></i>
                    Afegir nota
                </a>
            </div>

            @if ($trip->notes->isNotEmpty())
                <div class="row g-4">
                    @foreach ($trip->notes as $note)
                        <div class="col-12 col-lg-6">
                            <x-card class="note-card h-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <span class="tm-icon-circle">
                                            <i class="bi bi-journal-text"></i>
                                        </span>

                                        <h3 class="h5 fw-bold mb-0">
                                            {{ $note->title }}
                                        </h3>
                                    </div>

                                    <p class="text-muted mb-4">
                                        {!! nl2br(e($note->content)) !!}
                                    </p>

                                    <form action="{{ route('notes.destroy', [$trip, $note]) }}" method="POST"
                                        class="mt-auto"
                                        onsubmit="return confirm('Segur que vols esborrar aquesta nota?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash me-1"></i>
                                            Esborrar
                                        </button>
                                    </form>
                                </div>
                            </x-card>
                        </div>
                    @endforeach
                </div>
            @else
                <x-card>
                    <x-empty-state title="No hi ha notes"
                        description="Afegeix recordatoris, idees o informació útil relacionada amb aquest viatge."
                        icon="bi-journal-text">
                        <x-slot:action>
                            <a href="{{ route('notes.create', $trip) }}" class="btn btn-outline-primary">
                                <i class="bi bi-journal-plus me-1"></i>
                                Afegir la primera nota
                            </a>
                        </x-slot:action>
                    </x-empty-state>
                </x-card>
            @endif
        </section>

    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const places = {{ Illuminate\Support\Js::from($mapPlaces) }};

            if (places.length === 0) {
                return;
            }

            const mapElement = document.getElementById('trip-map');

            if (!mapElement || typeof L === 'undefined') {
                console.error('No s’ha pogut inicialitzar Leaflet.');

                return;
            }

            function escapeHtml(value) {
                const element = document.createElement('div');

                element.textContent = value ?? '';

                return element.innerHTML;
            }

            const map = L.map('trip-map', {
                scrollWheelZoom: true
            }).setView([20, 0], 2);

            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }
            ).addTo(map);

            const markers = [];

            places.forEach(function(place) {
                const latitude = Number(place.latitude);
                const longitude = Number(place.longitude);

                if (
                    !Number.isFinite(latitude) ||
                    !Number.isFinite(longitude)
                ) {
                    return;
                }

                const googleMapsUrl =
                    `https://www.google.com/maps?q=${latitude},${longitude}`;

                const popupContent = `
                    <div style="min-width: 190px;">
                        <strong>${escapeHtml(place.name)}</strong>
                        <br>
                        ${escapeHtml(place.country)}
                        <br>
                        ${escapeHtml(place.category)}
                        <br>
                        ${place.visited ? '✓ Visitat' : '○ Pendent'}
                        <br><br>

                        <a
                            href="${googleMapsUrl}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-sm btn-primary"
                        >
                            Obrir a Google Maps
                        </a>
                    </div>
                `;

                const marker = L.marker([latitude, longitude])
                    .addTo(map)
                    .bindPopup(popupContent);

                markers.push(marker);
            });

            if (markers.length === 1) {
                map.setView(markers[0].getLatLng(), 14);
            } else if (markers.length > 1) {
                const markerGroup = L.featureGroup(markers);

                map.fitBounds(
                    markerGroup.getBounds().pad(0.2)
                );
            }

            requestAnimationFrame(function() {
                map.invalidateSize();
            });

            setTimeout(function() {
                map.invalidateSize();
            }, 250);
        });
    </script>

</x-app-layout>
