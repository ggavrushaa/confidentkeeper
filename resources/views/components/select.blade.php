@props(['value' => null])

<select {{ $attributes->class(['form-control']) }}>
    {{ $slot }}
</select>