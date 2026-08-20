<x-app-layout>

    <x-slot name="header">
        <x-page-header title="Categories">
            <x-slot:subtitle>
                Organitza els llocs dels teus viatges mitjançant categories.
            </x-slot:subtitle>

            <x-slot:actions>
                <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nova categoria
                </a>
            </x-slot:actions>
        </x-page-header>
    </x-slot>

    <style>
        .category-card {
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 32px rgba(23, 32, 51, 0.1) !important;
        }

        .category-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border-radius: 14px;
            color: var(--tm-primary);
            background: rgba(30, 111, 217, 0.1);
            font-size: 1.25rem;
        }

        .category-count {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.75rem;
            border-radius: 999px;
            color: #64748b;
            background: #f8fafc;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .category-actions {
            padding-top: 1rem;
            margin-top: auto;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
        }

        @media (max-width: 575.98px) {

            .category-actions,
            .category-actions form,
            .category-actions .btn {
                width: 100%;
            }
        }
    </style>

    <div class="container py-4">

        <x-flash-message />

        @if ($categories->isEmpty())
            <x-card>
                <x-empty-state title="Encara no tens categories"
                    description="Crea categories per organitzar els llocs dels teus viatges, com ara restaurants, monuments o allotjaments."
                    icon="bi-tags">
                    <x-slot:action>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i>
                            Crear la primera categoria
                        </a>
                    </x-slot:action>
                </x-empty-state>
            </x-card>
        @else
            <div class="row g-4">
                @foreach ($categories as $category)
                    <div class="col-12 col-md-6 col-xl-4">
                        <x-card class="category-card h-100">
                            <div class="d-flex flex-column h-100">

                                <div class="d-flex align-items-start gap-3 mb-4">
                                    <span class="category-icon">
                                        <i class="bi bi-tag"></i>
                                    </span>

                                    <div class="flex-grow-1 min-width-0">
                                        <span class="tm-section-label">
                                            Categoria
                                        </span>

                                        <h2 class="h5 fw-bold mt-1 mb-2">
                                            {{ $category->name }}
                                        </h2>

                                        <span class="category-count">
                                            <i class="bi bi-geo-alt"></i>

                                            {{ $category->places->count() }}

                                            {{ $category->places->count() === 1 ? 'lloc associat' : 'llocs associats' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="category-actions d-flex flex-wrap gap-2">
                                    <a href="{{ route('categories.edit', $category) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-pencil me-1"></i>
                                        Editar
                                    </a>

                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                        class="ms-sm-auto"
                                        onsubmit="return confirm('Segur que vols esborrar aquesta categoria?');">
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
        @endif

    </div>

</x-app-layout>
