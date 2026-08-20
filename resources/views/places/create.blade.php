<x-app-layout>

    <x-slot name="header">
        <x-page-header title="Nou lloc" :back-route="route('trips.show', $trip)" :back-text="$trip->title">
            <x-slot:subtitle>
                Afegeix un lloc nou al viatge i localitza’l automàticament al mapa.
            </x-slot:subtitle>
        </x-page-header>
    </x-slot>

    <style>
        .form-card {
            max-width: 980px;
            margin: 0 auto;
        }

        .form-section-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            border-radius: 16px;
            color: var(--tm-primary);
            background: rgba(30, 111, 217, 0.10);
            font-size: 1.35rem;
        }

        .form-control,
        .form-select {
            min-height: 48px;
            border-radius: 12px;
            border-color: #dbe3ee;
        }

        textarea.form-control {
            min-height: 130px;
            resize: vertical;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(30, 111, 217, 0.55);
            box-shadow: 0 0 0 0.25rem rgba(30, 111, 217, 0.12);
        }

        .form-help {
            color: #64748b;
            font-size: 0.85rem;
        }

        .form-section {
            padding-bottom: 1.75rem;
            margin-bottom: 1.75rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }

        .location-card {
            padding: 1.5rem;
            border: 1px solid rgba(30, 111, 217, 0.14);
            border-radius: 18px;
            background: linear-gradient(135deg,
                    rgba(30, 111, 217, 0.06),
                    rgba(255, 255, 255, 0.96));
        }

        .location-card-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border-radius: 14px;
            color: var(--tm-primary);
            background: rgba(30, 111, 217, 0.12);
            font-size: 1.15rem;
        }

        .location-result {
            padding: 1rem;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 14px;
            background: #ffffff;
        }

        .coordinates-box {
            padding: 1.25rem;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 16px;
            background: #f8fafc;
        }

        .category-warning {
            border-radius: 14px;
        }

        .form-actions {
            padding-top: 0.25rem;
        }

        @media (max-width: 575.98px) {
            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
            }

            #search-location {
                width: 100%;
            }
        }
    </style>

    <div class="container py-4">

        <div class="form-card">

            <x-card>

                <div class="d-flex align-items-start gap-3 mb-4">

                    <span class="form-section-icon">
                        <i class="bi bi-geo-alt"></i>
                    </span>

                    <div>
                        <span class="tm-section-label">
                            Nou lloc
                        </span>

                        <h2 class="h4 fw-bold mt-1 mb-2">
                            Afegir lloc a {{ $trip->title }}
                        </h2>

                        <p class="text-muted mb-0">
                            Introdueix la informació del lloc i utilitza la cerca automàtica per obtenir-ne les
                            coordenades.
                        </p>
                    </div>

                </div>

                <form action="{{ route('places.store', $trip) }}" method="POST">
                    @csrf

                    <div class="form-section">

                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-info-circle text-primary"></i>

                            <h3 class="h6 fw-bold mb-0">
                                Informació bàsica
                            </h3>
                        </div>

                        <div class="row g-4">

                            <div class="col-12 col-lg-7">

                                <label for="name" class="form-label fw-semibold">
                                    Nom del lloc
                                </label>

                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Ex. Tokyo Tower" required autofocus>

                                <div class="form-help mt-2">
                                    Pots indicar un monument, un restaurant, un hotel o qualsevol punt d’interès.
                                </div>

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="col-12 col-lg-5">

                                <label for="country" class="form-label fw-semibold">
                                    País
                                </label>

                                <input type="text" name="country" id="country"
                                    class="form-control @error('country') is-invalid @enderror"
                                    value="{{ old('country', $trip->country) }}" placeholder="Ex. Japó" required>

                                <div class="form-help mt-2">
                                    S’ha emplenat amb el país del viatge.
                                </div>

                                @error('country')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="col-12">

                                <label for="category_id" class="form-label fw-semibold">
                                    Categoria
                                </label>

                                @if ($categories->isNotEmpty())

                                    <select name="category_id" id="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">
                                            Selecciona una categoria
                                        </option>

                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="form-help mt-2">
                                        La categoria t’ajudarà a organitzar i identificar els llocs.
                                    </div>

                                    @error('category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                @else
                                    <div class="alert alert-warning category-warning mb-3">
                                        <div class="d-flex align-items-start gap-2">
                                            <i class="bi bi-exclamation-triangle-fill mt-1"></i>

                                            <div>
                                                <strong>
                                                    No tens cap categoria creada.
                                                </strong>

                                                <div class="small mt-1">
                                                    Has de crear almenys una categoria abans de poder guardar el lloc.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{ route('categories.create') }}" class="btn btn-outline-primary">
                                        <i class="bi bi-plus-lg me-1"></i>
                                        Crear una categoria
                                    </a>

                                @endif

                            </div>

                            <div class="col-12">

                                <label for="description" class="form-label fw-semibold">
                                    Descripció
                                </label>

                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="4" maxlength="550" placeholder="Informació, recomanacions o comentaris sobre el lloc...">{{ old('description') }}</textarea>

                                <div class="d-flex justify-content-between gap-3 mt-2">
                                    <div class="form-help">
                                        Aquest camp és opcional.
                                    </div>

                                    <div class="form-help">
                                        Màxim 550 caràcters
                                    </div>
                                </div>

                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                    <div class="form-section">

                        <div class="location-card">

                            <div class="d-flex align-items-start gap-3 mb-3">

                                <span class="location-card-icon">
                                    <i class="bi bi-map"></i>
                                </span>

                                <div>
                                    <h3 class="h6 fw-bold mb-1">
                                        Ubicació al mapa
                                    </h3>

                                    <p class="text-muted small mb-0">
                                        Escriu el nom del lloc i el país, i després prem el botó per obtenir-ne
                                        automàticament les coordenades.
                                    </p>
                                </div>

                            </div>

                            <button type="button" id="search-location" class="btn btn-outline-primary">
                                <i class="bi bi-search me-1"></i>
                                Buscar ubicació
                            </button>

                            <div id="location-message" class="mt-3" role="status" aria-live="polite"></div>

                            <div id="location-result" class="location-result mt-3 d-none">

                                <div class="d-flex align-items-start gap-2 mb-2">
                                    <i class="bi bi-check-circle-fill text-success mt-1"></i>

                                    <strong>
                                        Ubicació trobada
                                    </strong>
                                </div>

                                <p id="location-display-name" class="text-muted small mb-3"></p>

                                <a id="open-osm-link" href="#" target="_blank" rel="noopener noreferrer"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-box-arrow-up-right me-1"></i>
                                    Veure a OpenStreetMap
                                </a>

                            </div>

                        </div>

                    </div>

                    <div class="form-section">

                        <div class="d-flex align-items-start gap-2 mb-3">
                            <i class="bi bi-crosshair text-primary mt-1"></i>

                            <div>
                                <h3 class="h6 fw-bold mb-1">
                                    Coordenades
                                </h3>

                                <p class="form-help mb-0">
                                    S’emplenaran automàticament després de buscar la ubicació, però també les pots
                                    modificar manualment.
                                </p>
                            </div>
                        </div>

                        <div class="coordinates-box">

                            <div class="row g-4">

                                <div class="col-12 col-md-6">

                                    <label for="latitude" class="form-label fw-semibold">
                                        Latitud
                                    </label>

                                    <input type="number" step="any" name="latitude" id="latitude"
                                        class="form-control @error('latitude') is-invalid @enderror"
                                        value="{{ old('latitude') }}" placeholder="Ex. 35.6586">

                                    @error('latitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-12 col-md-6">

                                    <label for="longitude" class="form-label fw-semibold">
                                        Longitud
                                    </label>

                                    <input type="number" step="any" name="longitude" id="longitude"
                                        class="form-control @error('longitude') is-invalid @enderror"
                                        value="{{ old('longitude') }}" placeholder="Ex. 139.7454">

                                    @error('longitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="form-help mt-3">
                                <i class="bi bi-info-circle me-1"></i>
                                Les coordenades són opcionals. Pots deixar-les buides i afegir-les més endavant.
                            </div>

                        </div>

                    </div>

                    <div class="form-actions d-flex flex-wrap gap-2">

                        <button type="submit" class="btn btn-primary"
                            {{ $categories->isEmpty() ? 'disabled' : '' }}>
                            <i class="bi bi-check-lg me-1"></i>
                            Guardar lloc
                        </button>

                        <a href="{{ route('trips.show', $trip) }}" class="btn btn-outline-secondary">
                            Cancel·lar
                        </a>

                    </div>

                </form>

            </x-card>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchButton = document.getElementById('search-location');
            const nameInput = document.getElementById('name');
            const countryInput = document.getElementById('country');
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');

            const locationMessage = document.getElementById('location-message');
            const locationResult = document.getElementById('location-result');
            const locationDisplayName = document.getElementById('location-display-name');
            const openOsmLink = document.getElementById('open-osm-link');

            function showMessage(message, type) {
                locationMessage.className = `alert alert-${type} mt-3 mb-0`;
                locationMessage.textContent = message;
            }

            function clearResult() {
                locationResult.classList.add('d-none');
                locationDisplayName.textContent = '';
                openOsmLink.href = '#';
            }

            searchButton.addEventListener('click', async function() {
                const placeName = nameInput.value.trim();
                const country = countryInput.value.trim();

                clearResult();

                if (!placeName || !country) {
                    showMessage(
                        'Escriu el nom del lloc i el país abans de buscar.',
                        'warning'
                    );

                    return;
                }

                const originalButtonContent = searchButton.innerHTML;

                searchButton.disabled = true;
                searchButton.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm me-2"
                    aria-hidden="true"
                ></span>
                Buscant...
            `;

                showMessage('Buscant la ubicació...', 'info');

                const query = `${placeName}, ${country}`;

                const searchParameters = new URLSearchParams({
                    q: query,
                    format: 'jsonv2',
                    limit: '1',
                    addressdetails: '1',
                    accept_language: 'ca'
                });

                try {
                    const response = await fetch(
                        `https://nominatim.openstreetmap.org/search?${searchParameters.toString()}`, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json'
                            }
                        }
                    );

                    if (!response.ok) {
                        throw new Error(
                            `La consulta ha retornat l'error ${response.status}`
                        );
                    }

                    const results = await response.json();

                    if (!Array.isArray(results) || results.length === 0) {
                        showMessage(
                            'No s’ha trobat cap ubicació. Prova amb un nom més concret, una ciutat o una adreça.',
                            'warning'
                        );

                        return;
                    }

                    const location = results[0];
                    const latitude = Number(location.lat);
                    const longitude = Number(location.lon);

                    if (
                        !Number.isFinite(latitude) ||
                        !Number.isFinite(longitude)
                    ) {
                        throw new Error(
                            'Les coordenades rebudes no són vàlides.'
                        );
                    }

                    latitudeInput.value = latitude;
                    longitudeInput.value = longitude;

                    locationDisplayName.textContent = location.display_name;

                    openOsmLink.href =
                        `https://www.openstreetmap.org/?mlat=${latitude}` +
                        `&mlon=${longitude}` +
                        `#map=17/${latitude}/${longitude}`;

                    locationResult.classList.remove('d-none');

                    showMessage(
                        'Ubicació trobada. Les coordenades s’han emplenat automàticament.',
                        'success'
                    );
                } catch (error) {
                    console.error('Error en buscar la ubicació:', error);

                    showMessage(
                        'No s’ha pogut completar la cerca. Revisa la connexió i torna-ho a provar.',
                        'danger'
                    );
                } finally {
                    searchButton.disabled = false;
                    searchButton.innerHTML = originalButtonContent;
                }
            });
        });
    </script>

</x-app-layout>
