@props(['src', 'width', 'height', 'sizes', 'loading' => 'lazy', 'priority' => 'low'])
@php($image = \App\Support\ResponsiveImages::get($src))
<picture>
    @if ($image['avif'])
        <source type="image/avif" srcset="{{ $image['avif'] }}" sizes="{{ $sizes }}">
    @endif
    <img src="{{ $image['fallback'] }}" srcset="{{ $image['webp'] }}" sizes="{{ $sizes }}"
         width="{{ $width }}" height="{{ $height }}" loading="{{ $loading }}" decoding="async" fetchpriority="{{ $priority }}" {{ $attributes }}>
</picture>
