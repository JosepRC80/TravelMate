<x-app-layout>

    <x-slot name="header">
        <x-page-header title="Editar categoria" :back-route="route('categories.index')" back-text="Categories">
            <x-slot:subtitle>
                Modifica el nom de la categoria.
            </x-slot:subtitle>
        </x-page-header>
    </x-slot>

    <style>
        .form-card {
            max-width: 720px;
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

        .form-control:focus {
            border-color: rgba(30, 111, 217, .55);
            box-shadow: 0 0 0 .25rem rgba(30, 111, 217, .12);
        }

        .form-help {
            color: #64748b;
            font-size: .85rem;
        }

        .form-actions {
            margin-top: 1.75rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(15, 23, 42, .08);
        }

        @media (max-width: 575px) {
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
                        <i class="bi bi-pencil-square"></i>
                    </span>

                    <div>

                        <span class="tm-section-label">
                            Editar categoria
                        </span>

                        <h2 class="h4 fw-bold mt-1 mb-2">
                            {{ $category->name }}
                        </h2>

                        <p class="text-muted mb-0">
                            Actualitza el nom de la categoria. Els llocs associats conservaran aquesta categoria
                            automàticament.
                        </p>

                    </div>

                </div>

                <form action="{{ route('categories.update', $category) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">

                        <label for="name" class="form-label fw-semibold">
                            Nom de la categoria
                        </label>

                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $category->name) }}" placeholder="Nom de la categoria" required
                            autofocus>

                        <div class="form-help mt-2">
                            Utilitza un nom curt i descriptiu.
                        </div>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="form-actions d-flex gap-2">

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>
                            Desar canvis
                        </button>

                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                            Cancel·lar
                        </a>

                    </div>

                </form>

            </x-card>

        </div>

    </div>

</x-app-layout>
