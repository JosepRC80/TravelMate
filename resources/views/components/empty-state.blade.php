@props(['title', 'description' => null, 'icon' => 'bi-inbox'])

<div {{ $attributes->class(['text-center', 'py-5', 'px-3']) }}>
    <div class="mb-3">
        <i class="bi {{ $icon }} fs-1 text-muted" aria-hidden="true"></i>
    </div>

    <h3 class="h5 fw-bold mb-2">
        {{ $title }}
    </h3>

    @if ($description)
        <p class="text-muted mb-3">
            {{ $description }}
        </p>
    @endif

    @isset($action)
        <div>
            {{ $action }}
        </div>
    @endisset
</div>
