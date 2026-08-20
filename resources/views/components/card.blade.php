@props([
    'title' => null,
    'padding' => true,
])

<div {{ $attributes->class(['card shadow-sm border-0']) }}>
    @if ($title || isset($header))
        <div class="card-header bg-white border-0 px-4 pt-4 pb-0">
            @isset($header)
                {{ $header }}
            @else
                <h2 class="h5 fw-bold mb-0">
                    {{ $title }}
                </h2>
            @endisset
        </div>
    @endif

    <div @class([
        'card-body',
        'p-4' => $padding,
        'p-0' => ! $padding,
    ])>
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
            {{ $footer }}
        </div>
    @endisset
</div>