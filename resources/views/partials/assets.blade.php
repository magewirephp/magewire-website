<link rel="preload" href="{{ \App\Support\FrontendAssets::url('fonts/inter-latin-900-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ \App\Support\FrontendAssets::url('fonts/inter-latin-400-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="{{ \App\Support\FrontendAssets::url('css/app.css') }}">
<script src="{{ \App\Support\FrontendAssets::url('js/app.js') }}" defer></script>
@if ($hero ?? false)
    @php($sky = \App\Support\ResponsiveImages::get('/images/header/sky.webp'))
    <link rel="preload" as="image" href="{{ $sky['fallback'] }}" imagesrcset="{{ $sky['avif'] ?: $sky['webp'] }}"
          type="{{ $sky['avif'] ? 'image/avif' : 'image/webp' }}" imagesizes="(max-width: 1380px) 1380px, 100vw" fetchpriority="high">
@endif
