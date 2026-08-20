@props(['title', 'backRoute' => null, 'backText' => 'Tornar'])

<div
    {{ $attributes->class([
        'd-flex',
        'flex-column',
        'flex-sm-row',
        'justify-content-between',
        'align-items-sm-center',
        'gap-3',
        'mb-4',
    ]) }}>
    <div>
        <h1 class="h4 fw-bold mb-0">
            {{ $title }}
        </h1>

        @isset($subtitle)
            <div class="text-muted mt-1">
                {{ $subtitle }}
            </div>
        @endisset
    </div>

    <div class="d-flex flex-wrap align-items-center gap-2">
        @isset($actions)
            {{ $actions }}
        @endisset

        @if ($backRoute)
            <a href="{{ $backRoute }}" class="btn btn-outline-secondary btn-sm">
                ← {{ $backText }}
            </a>
        @endif
    </div>
</div>
