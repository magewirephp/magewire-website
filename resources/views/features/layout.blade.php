<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Magewire Features</title>
    <meta name="description" content="@yield('description')">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <meta name="theme-color" content="#f26322">
    <link rel="stylesheet" href="/css/app.css?v={{ filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/painted-ui.css?v={{ filemtime(public_path('css/painted-ui.css')) }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900|jetbrains-mono:400,500&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        :focus-visible { outline: 2px solid #f26322; outline-offset: 3px; border-radius: 4px; }
        .dot-grid {
            background-image: radial-gradient(circle, rgba(180, 161, 148, .55) 1.2px, transparent 1.2px);
            background-size: 28px 28px;
        }
        .code-scroll::-webkit-scrollbar { height: 5px; }
        .code-scroll::-webkit-scrollbar-track { background: transparent; }
        .code-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.16); border-radius: 99px; }
    </style>
</head>
<body class="overflow-x-hidden bg-[#fafafa] font-sans text-[#1a1a1a] antialiased">

<a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[9999] focus:rounded-xl focus:bg-mw-500 focus:px-4 focus:py-2 focus:font-semibold focus:text-white">
    Skip to main content
</a>

@include('partials.header', ['sticky' => true])

<nav aria-label="Feature pages" class="feature-nav sticky z-40 border-b border-[#e9e5e0] bg-[#fafafa]/95 backdrop-blur-xl">
    <div class="mx-auto flex max-w-6xl items-center gap-2 overflow-x-auto px-6 py-3">
        <span class="mr-3 hidden text-xs font-bold uppercase tracking-[.14em] text-[#a1a1aa] sm:inline">Features</span>
        <a href="{{ route('features.compiler') }}"
           @class([
               'whitespace-nowrap rounded-full px-4 py-2 text-sm font-semibold transition-colors',
               'bg-[#1d1d1f] text-white' => request()->routeIs('features.compiler'),
               'text-[#52525b] hover:bg-white hover:text-[#1d1d1f]' => ! request()->routeIs('features.compiler'),
           ])
           @if(request()->routeIs('features.compiler')) aria-current="page" @endif>
            Compiler
        </a>
        <a href="{{ route('features.fragments') }}"
           @class([
               'whitespace-nowrap rounded-full px-4 py-2 text-sm font-semibold transition-colors',
               'bg-[#1d1d1f] text-white' => request()->routeIs('features.fragments'),
               'text-[#52525b] hover:bg-white hover:text-[#1d1d1f]' => ! request()->routeIs('features.fragments'),
           ])
           @if(request()->routeIs('features.fragments')) aria-current="page" @endif>
            Fragments
        </a>
    </div>
</nav>

<main id="main">
    @yield('content')
</main>

@include('partials.footer')

@livewireScripts

</body>
</html>
