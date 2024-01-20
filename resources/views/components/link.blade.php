@props(['href' => '/', 'style' => '',])

<a href="{{ $href }}" style="color: inherit; text-decoration: none;" {{ $attributes }}>
    {{ $slot }}
</a>