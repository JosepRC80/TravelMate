<x-app-layout>

    <x-slot name="header">
        <x-page-header title="Nou viatge" :back-route="route('trips.index')" back-text="Els meus viatges">
            <x-slot:subtitle>
                Crea un nou viatge i comença a organitzar-ne els llocs, les categories i les notes.
            </x-slot:subtitle>
        </x-page-header>
    </x-slot>

    <style>
        .form-card {
            max-width: 920px;
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

        .form-control {
            min-height: 48px;
            border-radius: 12px;
            border-color: #dbe3ee;
        }

        textarea.form-control {
            min-height: 140px;
            resize: vertical;
        }

        .form-control:focus {
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
        }
    </style>

    <div class="container py-4">

        <div class="form-card">

            <x-card>

                <div class="d-flex align-items-start gap-3 mb-4">

                    <span class="form-section-icon">
                        <i class="bi bi-airplane"></i>
                    </span>

                    <div>
                        <span class="tm-section-label">
                            Nou viatge
                        </span>

                        <h2 class="h4 fw-bold mt-1 mb-2">
                            Informació del viatge
                        </h2>

                        <p class="text-muted mb-0">
                            Introdueix les dades principals. Més endavant hi podràs afegir llocs, categories i notes.
                        </p>
                    </div>

                </div>

                <form method="POST" action="{{ route('trips.store') }}">
                    @csrf

                    <div class="form-section">

                        <div class="row g-4">

                            <div class="col-12 col-lg-7">

                                <label for="title" class="form-label fw-semibold">
                                    Títol
                                </label>

                                <input type="text" id="title" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}" placeholder="Ex. Viatge al Japó" required autofocus>

                                <div class="form-help mt-2">
                                    Utilitza un nom que identifiqui fàcilment el viatge.
                                </div>

                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="col-12 col-lg-5">

                                <label for="country" class="form-label fw-semibold">
                                    País
                                </label>

                                <input type="text" id="country" name="country"
                                    class="form-control @error('country') is-invalid @enderror"
                                    value="{{ old('country') }}" placeholder="Ex. Japó" required>

                                <div class="form-help mt-2">
                                    Aquest país es proposarà per defecte als llocs del viatge.
                                </div>

                                @error('country')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="col-12">

                                <label for="description" class="form-label fw-semibold">
                                    Descripció
                                </label>

                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="5" maxlength="550"
                                    placeholder="Afegeix una descripció, una idea general del viatge o informació que vulguis recordar...">{{ old('description') }}</textarea>

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

                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-calendar3 text-primary"></i>

                            <h3 class="h6 fw-bold mb-0">
                                Dates del viatge
                            </h3>
                        </div>

                        <div class="row g-4">

                            <div class="col-12 col-md-6">

                                <label for="start_date" class="form-label fw-semibold">
                                    Data d'inici
                                </label>

                                <input type="date" id="start_date" name="start_date"
                                    class="form-control @error('start_date') is-invalid @enderror"
                                    value="{{ old('start_date') }}">

                                @error('start_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="col-12 col-md-6">

                                <label for="end_date" class="form-label fw-semibold">
                                    Data final
                                </label>

                                <input type="date" id="end_date" name="end_date"
                                    class="form-control @error('end_date') is-invalid @enderror"
                                    value="{{ old('end_date') }}">

                                @error('end_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                    <div class="form-actions d-flex gap-2">

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>
                            Guardar viatge
                        </button>

                        <a href="{{ route('trips.index') }}" class="btn btn-outline-secondary">
                            Cancel·lar
                        </a>

                    </div>

                </form>

            </x-card>

        </div>

    </div>

</x-app-layout>
