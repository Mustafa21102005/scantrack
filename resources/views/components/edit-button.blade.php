@props(['class' => ''])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-inverse-warning ' . $class]) }}>
    Edit
</a>
