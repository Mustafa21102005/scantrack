@props(['class' => ''])

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-inverse-primary ' . $class]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn btn-inverse-primary ' . $class]) }}>
        {{ $slot }}
    </button>
@endif
