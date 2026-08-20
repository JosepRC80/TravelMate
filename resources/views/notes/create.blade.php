<x-app-layout>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">
                Nova nota
            </h5>

            <a href="{{ route('trips.show', $trip) }}" class="btn btn-outline-secondary btn-sm">
                ← {{ $trip->title }}
            </a>
        </div>
    </x-slot>

    <div class="container mt-4">

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    Viatge: {{ $trip->title }}
                </h5>

                <form action="{{ route('notes.store', $trip) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Títol</label>

                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ old('title') }}">

                        @error('title')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Contingut</label>

                        <textarea name="content" id="content" class="form-control" rows="6">{{ old('content') }}</textarea>

                        @error('content')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 mt-4">

                        <button type="submit" class="btn btn-primary">
                            Guardar nota
                        </button>

                        <a href="{{ route('trips.show', $trip) }}" class="btn btn-outline-secondary">
                            Cancel·lar
                        </a>

                    </div>

                </form>

            </div>
        </div>

    </div>

</x-app-layout>
