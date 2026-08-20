<x-app-layout>

    <x-slot name="header">
        <x-page-header title="Nova categoria" :back-route="route('categories.index')" back-text="Categories">
            <x-slot:subtitle>
                Crea una categoria nova per organitzar millor els llocs dels teus viatges.
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
            background: rgba(30, 111, 217, 0.1);
            font-size: 1.35rem;
        }

        .form-control {
            min-height: 48px;
            border-radius: 12px;
            border-color: #dbe3ee;
        }

        .form-control:focus {
            border-color: rgba(30, 111, 217, 0.55);
            box-shadow: 0 0 0 0.25rem rgba(30, 111, 217, 0.12);
        }

        .form-help {
            color: #64748b;
            font-size: 0.85rem;
        }

        .form-actions {
            padding-top: 1.5rem;
            margin-top: 1.5rem;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
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
                        <i class="bi bi-tag"></i>
                    </span>

                    <div>
                        <span class="tm-section-label">
                            Nova categoria
                        </span>

                        <h2 class="h4 fw-bold mt-1 mb-2">
                            Informació de la categoria
                        </h2>

                        <p class="text-muted mb-0">
                            Assigna un nom clar que puguis reutilitzar als llocs dels teus viatges.
                        </p>
                    </div>
                </div>

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">
                            Nom de la categoria
                        </label>

                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                            placeholder="Ex. Restaurants, monuments, allotjaments..." required autofocus>

                        <div class="form-help mt-2">
                            Tria un nom curt i fàcil d’identificar.
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
                            Guardar categoria
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
