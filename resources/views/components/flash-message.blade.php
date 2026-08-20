@props([
    'key' => 'message',
    'type' => 'success',
])

@if (session()->has($key))
    <div {{ $attributes->class(['alert', "alert-{$type}", 'alert-dismissible', 'fade', 'show', 'shadow-sm']) }}
        role="alert" data-flash-message>
        {{ session($key) }}

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tancar"></button>
    </div>
@endif
