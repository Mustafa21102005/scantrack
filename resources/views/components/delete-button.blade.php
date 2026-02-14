@props(['class' => ''])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn btn-inverse-danger ' . $class]) }}>
    {{ $slot }}
</button>
