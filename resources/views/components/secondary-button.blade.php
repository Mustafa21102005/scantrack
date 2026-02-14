@props(['class' => ''])

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-inverse-secondary ' . $class]) }}
        style="color:
    inherit;">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn btn-inverse-secondary ' . $class]) }}
        style="color:
    inherit;">
        {{ $slot }}
    </button>
@endif

<style>
    .btn-inverse-secondary:hover {
        background-color: white !important;
        color: black !important;
    }
</style>
