@props([
    'title' => null,
])

<svg
    xmlns="http://www.w3.org/2000/svg" 
    fill="none" 
    viewBox="0 0 24 24" 
    stroke-width="1.1"
    stroke="currentColor"
    {{ $attributes->merge([
        'class' => 'inline-block shrink-0',
        'aria-hidden' => $title ? 'false' : 'true',
        'role' => 'img',
    ]) }}
>
    @if($title)
        <title>{{ $title }}</title>
    @endif

    {{ $slot }}
</svg>
