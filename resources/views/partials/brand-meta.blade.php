@php
    $brandImage = url(\App\Support\FrontendAssets::url('brand/magewire/png/social-light-1200.png'));
@endphp
<link rel="icon" href="{{ \App\Support\FrontendAssets::url('favicon.ico') }}" sizes="any">
<link rel="icon" href="{{ \App\Support\FrontendAssets::url('favicon.svg') }}" type="image/svg+xml">
<link rel="apple-touch-icon" href="{{ \App\Support\FrontendAssets::url('apple-touch-icon.png') }}">
<link rel="manifest" href="{{ \App\Support\FrontendAssets::url('brand/magewire/icons/site.webmanifest') }}">
<meta name="theme-color" content="#ff4f00">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Magewire">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:image" content="{{ $brandImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="The Magewire character and wordmark">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ $brandImage }}">
<meta name="twitter:image:alt" content="The Magewire character and wordmark">
