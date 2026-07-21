<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') — Magewire Features</title>
    <meta name="description" content="@yield('description')">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <meta name="theme-color" content="#f26322">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900|jetbrains-mono:400,500&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                fontFamily: {
                    sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    mono: ['JetBrains Mono', 'ui-monospace', 'SFMono-Regular', 'monospace'],
                },
                extend: {
                    colors: {
                        mw: {
                            50: '#fff4ee', 100: '#ffe6d3', 200: '#ffc9a6', 300: '#ffa36d',
                            400: '#ff7232', 500: '#f26322', 600: '#e04e0f', 700: '#b83a0e',
                            800: '#932f13', 900: '#772913',
                        },
                    },
                },
            },
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        :focus-visible { outline: 2px solid #f26322; outline-offset: 3px; border-radius: 4px; }
        .nav-link {
            padding: .375rem .75rem;
            border-radius: 9999px;
            color: #52525b;
            font-size: .9375rem;
            font-weight: 500;
            transition: color .15s, background .15s;
        }
        .nav-link:hover, .nav-link.active { color: #e04e0f; background: #fff4ee; }
        .dot-grid {
            background-image: radial-gradient(circle, rgba(180, 161, 148, .55) 1.2px, transparent 1.2px);
            background-size: 28px 28px;
        }
        .code-scroll::-webkit-scrollbar { height: 5px; }
        .code-scroll::-webkit-scrollbar-track { background: transparent; }
        .code-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.16); border-radius: 99px; }
    </style>
</head>
<body class="overflow-x-hidden bg-[#fafaf8] font-sans text-[#1a1a1a] antialiased">

<a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[9999] focus:rounded-xl focus:bg-mw-500 focus:px-4 focus:py-2 focus:font-semibold focus:text-white">
    Skip to main content
</a>

<header role="banner" x-data="{ menu: false }" @keydown.escape.window="menu = false"
        class="sticky top-0 z-50 border-b border-[#ece9e5] bg-white/90 backdrop-blur-xl">
    <div class="mx-auto flex h-[68px] max-w-6xl items-center justify-between px-6">
        <a href="/" aria-label="Magewire, go to homepage" class="group flex shrink-0 select-none items-center gap-2.5">
            <img src="/favicon.svg" alt="" width="28" height="28" class="h-7 w-7 rounded-[7px] shadow-sm">
            <span class="text-[18px] font-bold tracking-tight text-[#1d1d1f] transition-colors group-hover:text-mw-600">MagewirePHP</span>
        </a>

        <nav aria-label="Primary" class="hidden items-center gap-1 md:flex">
            <a href="https://docs.magewirephp.nl/?ref=main-website" target="_blank" rel="noopener" class="nav-link">Docs</a>
            <a href="{{ route('features.compiler') }}" class="nav-link active" aria-current="page">Features</a>
            <a href="{{ url('/') }}#install" class="nav-link">Install</a>
            <a href="{{ url('/') }}#compatibility" class="nav-link">Compatibility</a>
            <a href="{{ url('/') }}#sponsors" class="nav-link">Sponsors</a>
            <a href="https://docs.magewirephp.nl/blogs/?ref=main-website" target="_blank" rel="noopener" class="nav-link">Blog</a>
        </nav>

        <div class="flex shrink-0 items-center gap-2">
            <a href="https://github.com/magewirephp/magewire" target="_blank" rel="noopener" aria-label="Magewire on GitHub"
               class="flex h-9 w-9 items-center justify-center rounded-full border border-[#d2d2d7] text-[#52525b] transition-colors hover:border-mw-500 hover:text-mw-600">
                <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                </svg>
            </a>
            <button @click="menu = !menu" :aria-expanded="menu" aria-controls="feature-mobile-menu"
                    class="flex h-9 w-9 items-center justify-center rounded-full border border-[#d2d2d7] text-[#52525b] transition-colors hover:border-mw-500 hover:text-mw-600 md:hidden"
                    aria-label="Toggle navigation menu">
                <svg x-show="!menu" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-show="menu" x-cloak width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
    </div>

    <nav id="feature-mobile-menu" x-show="menu" x-cloak x-transition.opacity aria-label="Mobile" class="border-t border-[#e8e5e1] bg-white/95 md:hidden">
        <div class="mx-auto flex max-w-6xl flex-col px-6 py-3">
            <a href="https://docs.magewirephp.nl/?ref=main-website" target="_blank" rel="noopener" class="border-b border-[#f0ece7] py-3 font-medium">Docs</a>
            <a href="{{ route('features.compiler') }}" class="border-b border-[#f0ece7] py-3 font-semibold text-mw-600" aria-current="page">Features</a>
            <a href="{{ url('/') }}#install" class="border-b border-[#f0ece7] py-3 font-medium">Install</a>
            <a href="{{ url('/') }}#compatibility" class="border-b border-[#f0ece7] py-3 font-medium">Compatibility</a>
            <a href="{{ url('/') }}#sponsors" class="border-b border-[#f0ece7] py-3 font-medium">Sponsors</a>
            <a href="https://docs.magewirephp.nl/blogs/?ref=main-website" target="_blank" rel="noopener" class="py-3 font-medium">Blog</a>
        </div>
    </nav>
</header>

<nav aria-label="Feature pages" class="sticky top-[68px] z-40 border-b border-[#e9e5e0] bg-[#fafaf8]/95 backdrop-blur-xl">
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

<footer class="bg-[#0f0f0e] px-6 py-12">
    <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-7 md:flex-row">
        <a href="/" class="font-bold text-[#d1d5db] transition-colors hover:text-white">MagewirePHP</a>
        <nav aria-label="Footer" class="flex flex-wrap items-center justify-center gap-6">
            <a href="https://docs.magewirephp.nl/?ref=main-website" target="_blank" rel="noopener" class="text-sm text-[#9ca3af] hover:text-white">Docs</a>
            <a href="{{ route('features.compiler') }}" class="text-sm text-white">Features</a>
            <a href="https://github.com/magewirephp/magewire" target="_blank" rel="noopener" class="text-sm text-[#9ca3af] hover:text-white">GitHub</a>
            <a href="https://discord.gg/magewire" target="_blank" rel="noopener" class="text-sm text-[#9ca3af] hover:text-white">Discord</a>
        </nav>
        <p class="text-sm text-[#73737a]">MIT License &mdash; &copy; {{ date('Y') }}</p>
    </div>
</footer>

</body>
</html>
