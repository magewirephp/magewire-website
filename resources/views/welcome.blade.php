<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Magewire: Reactive Magento, PHP-first</title>
    <meta name="description" content="MagewirePHP brings reactive, server-driven UI development to Magento 2. Build dynamic interfaces without writing JavaScript. V3 available now.">

    {{-- Favicon --}}
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
                         50: '#fff4ee',
                        100: '#ffe6d3',
                        200: '#ffc9a6',
                        300: '#ffa36d',
                        400: '#ff7232',
                        500: '#f26322',
                        600: '#e04e0f',
                        700: '#b83a0e',
                        800: '#932f13',
                        900: '#772913',
                    },
                },
            },
        },
    }
    </script>

    @fluxAppearance
    @fluxStyles

    <style>
        :root {
            --color-accent:             #f26322;
            --color-accent-foreground:  #ffffff;
            --color-accent-content:     #e04e0f;
        }

        /* ── Entrance animations ── */
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0);    }
        }
        .e1  { animation: fade-up .7s .00s ease both; }
        .e2  { animation: fade-up .7s .10s ease both; }
        .e3  { animation: fade-up .7s .22s ease both; }
        .e4  { animation: fade-up .7s .34s ease both; }
        .e4b { animation: fade-up .7s .46s ease both; }
        .e5  { animation: fade-up .7s .58s ease both; }

        /* ── Scroll-triggered reveal ── */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .65s cubic-bezier(.16,1,.3,1), transform .65s cubic-bezier(.16,1,.3,1);
        }
        .reveal.in-view { opacity: 1; transform: translateY(0); }

        /* ── Gradient text ── */
        .grad {
            background: linear-gradient(135deg, #ff8c42 0%, #f26322 40%, #c94b0a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Section eyebrow label ── */
        .eyebrow {
            display: inline-block;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #f26322;
            margin-bottom: 1rem;
        }

        /* ── Navigation ── */
        .nav-glass { transition: background .3s, box-shadow .3s, border-color .3s; }
        .nav-solid  {
            background: rgba(255,255,255,.88) !important;
            box-shadow: 0 1px 0 rgba(0,0,0,.06);
            border-bottom-color: #f0eeec !important;
        }
        .nav-link {
            font-size: .9375rem;
            font-weight: 500;
            color: #52525b;
            text-decoration: none;
            padding: .375rem .75rem;
            border-radius: 9999px;
            transition: color .15s, background .15s;
        }
        .nav-link:hover { color: #f26322; background: #fff4ee; }

        /* ── Code block scrollbar ── */
        .code-block { max-width: 100%; color: #e2e8f0; }
        .code-block::-webkit-scrollbar        { height: 5px; width: 5px; }
        .code-block::-webkit-scrollbar-track  { background: transparent; }
        .code-block::-webkit-scrollbar-thumb  { background: rgba(255,255,255,.15); border-radius: 99px; }

        /* ── Tab ── */
        .tab-btn {
            transition: color .15s, border-color .15s;
            border-bottom: 2px solid transparent;
            margin-bottom: -1px;
        }
        .tab-btn.active {
            border-bottom-color: white;
            color: white;
        }

        /* ── Card hover ── */
        .card-lift { transition: transform .2s, box-shadow .2s; }
        .card-lift:hover { transform: translateY(-2px); box-shadow: 0 12px 40px -8px rgba(0,0,0,.10); }

        /* ── Sponsor / feature card ── */
        .sponsor-card {
            transition: box-shadow .2s, transform .2s, border-color .2s;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }
        .sponsor-card:hover {
            transform: translateY(-2px);
            border-color: #f26322 !important;
            box-shadow: 0 8px 32px -4px rgba(242,99,34,.15), 0 1px 4px rgba(0,0,0,.04);
        }

        /* ── A11y ── */
        :focus-visible { outline: 2px solid #f26322; outline-offset: 3px; border-radius: 4px; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#fafaf8] text-[#1a1a1a] antialiased font-sans overflow-x-hidden">

{{-- Skip link --}}
<a href="#main"
   class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[9999]
          focus:bg-mw-500 focus:text-white focus:px-4 focus:py-2 focus:rounded-xl
          focus:font-semibold focus:shadow-lg">
    Skip to main content
</a>

{{-- ══════════════════════════════════
     NAVIGATION
     ══════════════════════════════════ --}}
<header id="site-nav" role="banner" x-data="{ menu: false }" @keydown.escape.window="menu = false"
        class="nav-glass fixed top-0 inset-x-0 z-50 border-b border-transparent bg-white/30 backdrop-blur-xl">
    <div class="mx-auto max-w-6xl px-6 flex items-center justify-between h-[68px]">

        {{-- Logo --}}
        <a href="/" aria-label="Magewire, go to homepage"
           class="shrink-0 select-none group">
            <span class="text-[18px] font-bold tracking-tight text-[#1d1d1f]
                         group-hover:text-mw-600 transition-colors">MagewirePHP</span>
        </a>

        {{-- Nav links --}}
        <nav aria-label="Primary" class="hidden md:flex items-center gap-1">
            <a href="https://docs.magewirephp.nl/?ref=main-website"
               target="_blank" rel="noopener" class="nav-link">Docs</a>
            <a href="{{ route('why') }}" class="nav-link">Why</a>
            <a href="#install"  class="nav-link">Install</a>
            <a href="#compatibility" class="nav-link">Compatibility</a>
            <a href="#sponsors" class="nav-link">Sponsors</a>
            <a href="https://docs.magewirephp.nl/blogs/?ref=main-website"
               target="_blank" rel="noopener" class="nav-link">Blog</a>
        </nav>

        {{-- GitHub + Discord icons --}}
        <div class="flex items-center gap-2 shrink-0">
            <a href="https://github.com/magewirephp/magewire"
               target="_blank" rel="noopener" aria-label="GitHub"
               class="w-9 h-9 flex items-center justify-center rounded-full border border-[#d2d2d7] text-[#52525b] hover:border-mw-500 hover:text-mw-600 transition-colors">
                <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                </svg>
            </a>
            <a href="https://discord.gg/magewire"
               target="_blank" rel="noopener" aria-label="Discord"
               class="w-9 h-9 flex items-center justify-center rounded-full border border-[#d2d2d7] text-[#52525b] hover:border-mw-500 hover:text-mw-600 transition-colors">
                <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057c.002.022.015.043.033.055a19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03ZM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418Zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418Z"/>
                </svg>
            </a>

            {{-- Mobile menu toggle --}}
            <button @click="menu = !menu" :aria-expanded="menu" aria-controls="mobile-menu"
                    class="md:hidden w-9 h-9 flex items-center justify-center rounded-full border border-[#d2d2d7] text-[#52525b] hover:border-mw-500 hover:text-mw-600 transition-colors"
                    aria-label="Toggle navigation menu">
                <svg x-show="!menu" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/>
                </svg>
                <svg x-show="menu" x-cloak width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

    </div>

    {{-- Mobile menu panel --}}
    <nav id="mobile-menu" x-show="menu" x-cloak x-transition.opacity aria-label="Mobile"
         class="md:hidden border-t border-[#e8e5e1] bg-white/90 backdrop-blur-xl">
        <div class="mx-auto max-w-6xl px-6 py-4 flex flex-col">
            <a href="https://docs.magewirephp.nl/?ref=main-website" target="_blank" rel="noopener" @click="menu = false"
               class="py-3 text-base font-medium text-[#1d1d1f] hover:text-mw-600 transition-colors border-b border-[#f0ece7]">Docs</a>
            <a href="{{ route('why') }}" @click="menu = false"
               class="py-3 text-base font-medium text-[#1d1d1f] hover:text-mw-600 transition-colors border-b border-[#f0ece7]">Why</a>
            <a href="#install" @click="menu = false"
               class="py-3 text-base font-medium text-[#1d1d1f] hover:text-mw-600 transition-colors border-b border-[#f0ece7]">Install</a>
            <a href="#compatibility" @click="menu = false"
               class="py-3 text-base font-medium text-[#1d1d1f] hover:text-mw-600 transition-colors border-b border-[#f0ece7]">Compatibility</a>
            <a href="#sponsors" @click="menu = false"
               class="py-3 text-base font-medium text-[#1d1d1f] hover:text-mw-600 transition-colors border-b border-[#f0ece7]">Sponsors</a>
            <a href="https://docs.magewirephp.nl/blogs/?ref=main-website" target="_blank" rel="noopener" @click="menu = false"
               class="py-3 text-base font-medium text-[#1d1d1f] hover:text-mw-600 transition-colors">Blog</a>
        </div>
    </nav>
</header>

<main id="main">

{{-- ══════════════════════════════════
     HERO: wave background
     ══════════════════════════════════ --}}
<section class="relative z-10 min-h-[100svh] flex flex-col items-center justify-center
                pt-24 pb-32 px-6 overflow-hidden">

    {{-- ── Background ── --}}
    <div aria-hidden="true" class="absolute inset-0 pointer-events-none overflow-hidden">
        {{-- Warm white base --}}
        <div class="absolute inset-0" style="background:#fafaf8;"></div>
        {{-- Dot grid --}}
        <svg class="absolute inset-0 w-full h-full opacity-[0.45]" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="hero-dots" x="0" y="0" width="28" height="28" patternUnits="userSpaceOnUse">
                    <circle cx="1.5" cy="1.5" r="1.5" fill="#d4c5bb"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#hero-dots)"/>
        </svg>
        {{-- Radial orange glow from top-center --}}
        <div class="absolute inset-0"
             style="background: radial-gradient(ellipse 75% 55% at 50% -5%, rgba(242,99,34,0.13) 0%, transparent 70%);"></div>
        {{-- Bottom fade to white --}}
        <div class="absolute bottom-0 inset-x-0 h-48"
             style="background: linear-gradient(to bottom, transparent, #fafaf8);"></div>
    </div>

    {{-- Hero content --}}
    <div class="relative z-10 w-full max-w-5xl mx-auto text-center">

        {{-- V3 badge --}}
        <div class="e1 inline-flex items-center gap-2.5 mb-10
                    text-sm font-semibold text-green-700 bg-green-50
                    border border-green-200 px-5 py-2 rounded-full shadow-sm">
            <span class="relative flex h-2.5 w-2.5 shrink-0" aria-hidden="true">
                <span class="absolute animate-ping inline-flex h-full w-full rounded-full bg-green-500 opacity-75"></span>
                <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-green-500"></span>
            </span>
            Magewire <strong class="font-bold">V3</strong>: Now Available
        </div>

        {{-- Headline --}}
        <h1 class="e2 text-[2rem] sm:text-5xl md:text-7xl lg:text-[5.5rem]
                   font-black tracking-tight leading-[1.08] sm:leading-[1.05] text-[#1a1a1a]">
            Reactive Magento<br>
            <span class="grad">without the JavaScript</span>
        </h1>

        <p class="e3 mt-6 text-lg sm:text-xl text-[#71717a] max-w-xl mx-auto leading-relaxed font-normal">
            Ship reactive Magento&nbsp;2 UIs in pure PHP. No JavaScript. No context switching. Just you and your code.
        </p>

        {{-- CTAs --}}
        <div class="e4 mt-12 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="https://docs.magewirephp.nl/?ref=main-website"
               target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 bg-mw-500 hover:bg-mw-600
                      text-white text-base font-semibold px-7 py-3.5 rounded-full
                      transition-colors shadow-lg shadow-mw-300/50">
                Read the Docs
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5"
                     viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
            <a href="#install"
               class="inline-flex items-center gap-2 bg-white border border-[#e4e2de]
                      text-[#52525b] text-base font-semibold px-7 py-3.5 rounded-full
                      hover:border-mw-300 hover:text-mw-600 transition-colors shadow-sm">
                Quick Install
            </a>
        </div>

        {{-- Live stats --}}
        <div x-data="{
                stars: 254,
                downloads: 1125229,
                fmt(n) {
                    if (n >= 1e6) return (n / 1e6).toFixed(1) + 'M';
                    if (n >= 1e3) return Math.round(n / 1e3) + 'K';
                    return n;
                },
                async init() {
                    try {
                        const [gh, pkg] = await Promise.all([
                            fetch('https://api.github.com/repos/magewirephp/magewire').then(r => r.json()),
                            fetch('https://packagist.org/packages/magewirephp/magewire.json').then(r => r.json()),
                        ]);
                        if (gh.stargazers_count) this.stars = gh.stargazers_count;
                        if (pkg.package?.downloads?.total) this.downloads = pkg.package.downloads.total;
                    } catch(e) {}
                }
             }"
             class="e4b mt-10 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm">
            <a href="https://github.com/magewirephp/magewire" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 text-[#6b7280] hover:text-[#1d1d1f] transition-colors">
                {{-- GitHub mark --}}
                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2C6.477 2 2 6.484 2 12.021c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.482 0-.237-.009-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0 1 12 6.844a9.59 9.59 0 0 1 2.504.337c1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482C19.138 20.197 22 16.444 22 12.021 22 6.484 17.522 2 12 2Z"/>
                </svg>
                <strong class="text-[#1d1d1f] font-bold" x-text="stars">254</strong>
                <span>stars</span>
            </a>
            <span class="w-px h-4 bg-[#d1d5db]" aria-hidden="true"></span>
            <a href="https://packagist.org/packages/magewirephp/magewire" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 text-[#6b7280] hover:text-[#1d1d1f] transition-colors">
                {{-- Download / package icon --}}
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75"
                     viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                <strong class="text-[#1d1d1f] font-bold" x-text="fmt(downloads)">1.1M</strong>
                <span>Packagist installs</span>
            </a>
        </div>

        {{-- Code editor: bleeds into Features section below --}}
        <div class="mt-20 px-6 relative z-10 w-full max-w-5xl mx-auto text-left">


            <div x-data="{ tab: 'php' }" class="w-full rounded-3xl overflow-hidden border border-[#3f3f46] shadow-2xl shadow-black/40">

                {{-- Tab bar --}}
                <div class="flex bg-[#1c1c1e] border-b border-[#3f3f46]">
                    <button @click="tab = 'php'"
                            :class="tab === 'php' ? 'active' : ''"
                            class="tab-btn text-sm font-mono font-medium
                                   text-[#9ca3af] hover:text-white px-5 py-3.5">
                        Counter.php
                    </button>
                    <button @click="tab = 'xml'"
                            :class="tab === 'xml' ? 'active' : ''"
                            class="tab-btn text-sm font-mono font-medium
                                   text-[#9ca3af] hover:text-white px-5 py-3.5">
                        default.xml
                    </button>
                    <button @click="tab = 'phtml'"
                            :class="tab === 'phtml' ? 'active' : ''"
                            class="tab-btn text-sm font-mono font-medium
                                   text-[#9ca3af] hover:text-white px-5 py-3.5">
                        counter.phtml
                    </button>
                </div>

                <div class="bg-[#111827]">
                <div style="display:grid">

                    {{-- PHP --}}
                    <div :style="tab === 'php' ? 'grid-area:1/1' : 'grid-area:1/1;visibility:hidden'">
<pre class="code-block overflow-x-auto text-sm leading-relaxed p-8 font-mono" aria-label="Counter PHP component"><code><span style="color:#9ca3af">&lt;?php</span>

<span style="color:#818cf8">declare</span><span style="color:#9ca3af">(</span><span style="color:#fcd34d">strict_types</span><span style="color:#9ca3af">=</span><span style="color:#86efac">1</span><span style="color:#9ca3af">);</span>

<span style="color:#818cf8">namespace</span> <span style="color:#e2e8f0">Vendor\Module\Magewire;</span>

<span style="color:#818cf8">use</span> <span style="color:#67e8f9">Magewire\Component;</span>

<span style="color:#818cf8">class</span> <span style="color:#fcd34d">Counter</span> <span style="color:#818cf8">extends</span> <span style="color:#67e8f9">Component</span>
<span style="color:#9ca3af">{</span>
    <span style="color:#818cf8">public int</span> <span style="color:#93c5fd">$count</span> <span style="color:#9ca3af">= </span><span style="color:#86efac">0</span><span style="color:#9ca3af">;</span>

    <span style="color:#818cf8">public function</span> <span style="color:#fcd34d">increment</span><span style="color:#9ca3af">():</span> <span style="color:#818cf8">void</span>
    <span style="color:#9ca3af">{</span>
        <span style="color:#93c5fd">$this</span><span style="color:#9ca3af">-&gt;</span><span style="color:#93c5fd">count</span><span style="color:#9ca3af">++;</span>
    <span style="color:#9ca3af">}</span>

    <span style="color:#818cf8">public function</span> <span style="color:#fcd34d">decrement</span><span style="color:#9ca3af">():</span> <span style="color:#818cf8">void</span>
    <span style="color:#9ca3af">{</span>
        <span style="color:#93c5fd">$this</span><span style="color:#9ca3af">-&gt;</span><span style="color:#93c5fd">count</span><span style="color:#9ca3af">--;</span>
    <span style="color:#9ca3af">}</span>
<span style="color:#9ca3af">}</span></code></pre>
                    </div>

                    {{-- XML --}}
                    <div :style="tab === 'xml' ? 'grid-area:1/1' : 'grid-area:1/1;visibility:hidden'">
<pre class="code-block overflow-x-auto text-sm leading-relaxed p-8 font-mono" aria-label="Magento layout XML registering the counter component"><code><span style="color:#9ca3af">&lt;?xml version="1.0"?&gt;</span>
<span style="color:#67e8f9">&lt;page</span>
    <span style="color:#86efac">xmlns:xsi</span><span style="color:#9ca3af">=</span><span style="color:#fcd34d">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span style="color:#86efac">xsi:noNamespaceSchemaLocation</span><span style="color:#9ca3af">=</span><span style="color:#fcd34d">"urn:magento:framework:View/Layout/etc/page_configuration.xsd"</span><span style="color:#67e8f9">&gt;</span>
    <span style="color:#67e8f9">&lt;body&gt;</span>
        <span style="color:#67e8f9">&lt;referenceContainer</span> <span style="color:#86efac">name</span><span style="color:#9ca3af">=</span><span style="color:#fcd34d">"content"</span><span style="color:#67e8f9">&gt;</span>
            <span style="color:#67e8f9">&lt;block</span>
                <span style="color:#86efac">name</span><span style="color:#9ca3af">=</span><span style="color:#fcd34d">"counter"</span>
                <span style="color:#86efac">template</span><span style="color:#9ca3af">=</span><span style="color:#fcd34d">"Vendor_Module::magewire/counter.phtml"</span><span style="color:#67e8f9">&gt;</span>
                <span style="color:#67e8f9">&lt;arguments&gt;</span>
                    <span style="color:#67e8f9">&lt;argument</span>
                        <span style="color:#86efac">name</span><span style="color:#9ca3af">=</span><span style="color:#fcd34d">"magewire"</span>
                        <span style="color:#86efac">xsi:type</span><span style="color:#9ca3af">=</span><span style="color:#fcd34d">"object"</span><span style="color:#67e8f9">&gt;</span>
                        <span style="color:#e2e8f0">Vendor\Module\Magewire\Counter</span>
                    <span style="color:#67e8f9">&lt;/argument&gt;</span>
                <span style="color:#67e8f9">&lt;/arguments&gt;</span>
            <span style="color:#67e8f9">&lt;/block&gt;</span>
        <span style="color:#67e8f9">&lt;/referenceContainer&gt;</span>
    <span style="color:#67e8f9">&lt;/body&gt;</span>
<span style="color:#67e8f9">&lt;/page&gt;</span></code></pre>
                    </div>

                    {{-- PHTML --}}
                    <div :style="tab === 'phtml' ? 'grid-area:1/1' : 'grid-area:1/1;visibility:hidden'">
<pre class="code-block overflow-x-auto text-sm leading-relaxed p-8 font-mono" aria-label="PHTML template for the counter component"><code><span style="color:#67e8f9">&lt;div</span> <span style="color:#86efac">class</span><span style="color:#9ca3af">=</span><span style="color:#fcd34d">"counter"</span><span style="color:#67e8f9">&gt;</span>

    <span style="color:#67e8f9">&lt;p</span> <span style="color:#86efac">class</span><span style="color:#9ca3af">=</span><span style="color:#fcd34d">"count"</span><span style="color:#67e8f9">&gt;</span>
        Count: <span style="color:#67e8f9">&lt;strong&gt;</span><span style="color:#9ca3af">&#123;&#123; </span><span style="color:#93c5fd">$magewire</span><span style="color:#9ca3af">-&gt;</span><span style="color:#93c5fd">count</span> <span style="color:#9ca3af">&#125;&#125;</span><span style="color:#67e8f9">&lt;/strong&gt;</span>
    <span style="color:#67e8f9">&lt;/p&gt;</span>

    <span style="color:#67e8f9">&lt;button</span> <span style="color:#86efac">wire:click</span><span style="color:#9ca3af">=</span><span style="color:#fcd34d">"increment"</span><span style="color:#67e8f9">&gt;</span>Increment<span style="color:#67e8f9">&lt;/button&gt;</span>
    <span style="color:#67e8f9">&lt;button</span> <span style="color:#86efac">wire:click</span><span style="color:#9ca3af">=</span><span style="color:#fcd34d">"decrement"</span><span style="color:#67e8f9">&gt;</span>Decrement<span style="color:#67e8f9">&lt;/button&gt;</span>

<span style="color:#67e8f9">&lt;/div&gt;</span></code></pre>
                    </div>

                </div>
                </div>
            </div>

        </div>

        {{-- Below-editor note --}}
        <p class="mt-8 text-center text-sm text-[#71717a] max-w-lg mx-auto leading-relaxed">
            This is just a counter. Magewire handles forms, modals, search, pagination, real-time validation, and much more.
            <a href="https://docs.magewirephp.nl/?ref=main-website" target="_blank" rel="noopener"
               class="text-mw-600 font-semibold hover:underline">Explore the docs</a>, get inspired, and ship something great.
        </p>

    </div>
</section>


{{-- ══════════════════════════════════
     INSTALLATION
     ══════════════════════════════════ --}}
<section id="install" class="-mt-52 pt-[260px] pb-36 px-6 bg-[#fafaf8] relative z-0"
         style="box-shadow: 0 -40px 80px 0 rgba(0,0,0,0.10)">
    <div class="mx-auto max-w-3xl">

        <div class="reveal text-center mb-16">
            <span class="eyebrow">Get started</span>
            <h2 class="text-5xl sm:text-6xl font-bold tracking-tight text-[#1a1a1a]">
                Install
            </h2>
            <p class="mt-6 text-lg text-[#71717a] max-w-xl mx-auto leading-relaxed">
                Three commands. You're up and running.
            </p>
        </div>

        <div x-data="{ copied: false }"
             class="reveal rounded-3xl overflow-hidden border border-[#3f3f46] shadow-2xl shadow-black/40"
             style="transition-delay:.15s">

            <div class="flex items-center justify-between bg-[#1c1c1e] px-6 py-4 border-b border-[#3f3f46]">
                <div class="flex gap-2" aria-hidden="true">
                    <div class="w-3 h-3 rounded-full bg-[#ff5f56]"></div>
                    <div class="w-3 h-3 rounded-full bg-[#febc2e]"></div>
                    <div class="w-3 h-3 rounded-full bg-[#28c840]"></div>
                </div>
                <span class="text-sm text-[#6b7280] font-mono">Terminal</span>
                <button
                    @click="
                        navigator.clipboard.writeText('composer require magewirephp/magewire\nphp bin/magento module:enable Magewirephp_Magewire\nphp bin/magento setup:upgrade');
                        copied = true;
                        setTimeout(() => copied = false, 2000)
                    "
                    class="text-sm text-[#6b7280] hover:text-white transition-colors font-medium"
                    aria-label="Copy install commands">
                    <span x-show="!copied">Copy</span>
                    <span x-show="copied" x-cloak class="text-green-400">Copied!</span>
                </button>
            </div>

            <div class="bg-[#111827] px-8 py-8 font-mono text-base leading-loose">
                <div class="flex items-start gap-3">
                    <span class="text-mw-500 select-none shrink-0">$</span>
                    <span class="text-[#e2e8f0]">composer require magewirephp/magewire</span>
                </div>
                <div class="flex items-start gap-3 mt-1">
                    <span class="text-mw-500 select-none shrink-0">$</span>
                    <span class="text-[#e2e8f0]">php bin/magento module:enable Magewirephp_Magewire</span>
                </div>
                <div class="flex items-start gap-3 mt-1">
                    <span class="text-mw-500 select-none shrink-0">$</span>
                    <span class="text-[#e2e8f0]">php bin/magento setup:upgrade</span>
                </div>
                <div class="flex items-start gap-3 mt-4">
                    <span class="text-green-500 select-none shrink-0">&#10003;</span>
                    <span class="text-[#6b7280]">Magewire is ready. Happy building!</span>
                </div>
            </div>

        </div>

        <p class="mt-8 text-center text-[#6e6e73] text-lg">
            Need more? Everything else is in the
            <a href="https://docs.magewirephp.nl/?ref=main-website"
               class="text-mw-500 font-semibold hover:underline" target="_blank" rel="noopener">
                documentation</a>.
        </p>

    </div>
</section>

{{-- ══════════════════════════════════
     LIVEWIRE PARITY
     ══════════════════════════════════ --}}
<section class="py-36 px-6 bg-[#fafaf8]">

    <div class="mx-auto max-w-5xl">

        {{-- Header --}}
        <div class="reveal text-center mb-16">
            <span class="eyebrow">Familiar by Design</span>
            <h2 class="text-5xl sm:text-6xl font-bold tracking-tight text-[#1a1a1a] mt-2">
                Know Livewire?<br>
                <span class="grad">You already know Magewire.</span>
            </h2>
            <p class="mt-5 text-lg text-[#6e6e73] max-w-2xl mx-auto leading-relaxed">
                Inspired by Laravel Livewire and intentionally familiar. Magewire brings its component model and <code class="font-mono text-mw-500">wire:</code> directives to Magento&nbsp;2, while adapting them to a different platform with different edges.
            </p>
        </div>

        {{-- ── PHP COMPARISON ── --}}
        <div class="reveal flex items-center gap-4 mb-4" style="transition-delay:.05s">
            <span class="text-xs font-mono font-medium text-[#9ca3af] uppercase tracking-widest">Component class</span>
            <span class="flex-1 h-px bg-[#e8e5e1]"></span>
        </div>

        <div class="reveal grid md:grid-cols-2 gap-4 items-start" style="transition-delay:.1s">

            {{-- Laravel Livewire PHP --}}
            <div class="rounded-2xl overflow-hidden border border-[#e8e5e1] shadow-sm">
                <div class="flex items-center bg-[#f5f3f0] px-5 py-3.5 border-b border-[#e8e5e1]">
                    <span class="text-sm font-semibold text-[#1d1d1f]">Laravel · Livewire</span>
                    <span class="ml-auto text-xs text-[#9ca3af] font-mono">Counter.php</span>
                </div>
<pre class="text-sm leading-relaxed p-5 font-mono overflow-x-auto bg-[#111110]"><code><span style="color:#9ca3af">&lt;?php</span>

<span style="color:#818cf8">namespace</span> <span style="color:#e2e8f0">App\Livewire;</span>

<span style="color:#818cf8">use</span> <span style="color:#67e8f9">Livewire\Component;</span>

<span style="color:#818cf8">class</span> <span style="color:#fcd34d">Counter</span> <span style="color:#818cf8">extends</span> <span style="color:#67e8f9">Component</span>
<span style="color:#9ca3af">{</span>
    <span style="color:#818cf8">public int</span> <span style="color:#93c5fd">$count</span> <span style="color:#9ca3af">= </span><span style="color:#86efac">0</span><span style="color:#9ca3af">;</span>

    <span style="color:#818cf8">public function</span> <span style="color:#fcd34d">increment</span><span style="color:#9ca3af">():</span> <span style="color:#818cf8">void</span>
    <span style="color:#9ca3af">{</span>
        <span style="color:#93c5fd">$this</span><span style="color:#9ca3af">-&gt;</span><span style="color:#93c5fd">count</span><span style="color:#9ca3af">++;</span>
    <span style="color:#9ca3af">}</span>

    <span style="color:#818cf8">public function</span> <span style="color:#fcd34d">decrement</span><span style="color:#9ca3af">():</span> <span style="color:#818cf8">void</span>
    <span style="color:#9ca3af">{</span>
        <span style="color:#93c5fd">$this</span><span style="color:#9ca3af">-&gt;</span><span style="color:#93c5fd">count</span><span style="color:#9ca3af">--;</span>
    <span style="color:#9ca3af">}</span>
<span style="color:#9ca3af">}</span></code></pre>
            </div>

            {{-- Magewire PHP --}}
            <div class="rounded-2xl overflow-hidden border border-[#e8e5e1] shadow-sm">
                <div class="flex items-center bg-[#f5f3f0] px-5 py-3.5 border-b border-[#e8e5e1]">
                    <span class="text-sm font-semibold text-[#1d1d1f]">Magento&nbsp;2 · Magewire</span>
                    <span class="ml-auto text-xs text-[#9ca3af] font-mono">Counter.php</span>
                </div>
<pre class="text-sm leading-relaxed p-5 font-mono overflow-x-auto bg-[#111110]"><code><span style="color:#9ca3af">&lt;?php</span>

<span style="color:#818cf8">namespace</span> <span style="background:rgba(242,99,34,0.18);border-radius:3px;padding:1px 4px"><span style="color:#e2e8f0">Vendor\Module\Magewire;</span></span>

<span style="color:#818cf8">use</span> <span style="background:rgba(242,99,34,0.18);border-radius:3px;padding:1px 4px"><span style="color:#67e8f9">Magewire\Component;</span></span>

<span style="color:#818cf8">class</span> <span style="color:#fcd34d">Counter</span> <span style="color:#818cf8">extends</span> <span style="color:#67e8f9">Component</span>
<span style="color:#9ca3af">{</span>
    <span style="color:#818cf8">public int</span> <span style="color:#93c5fd">$count</span> <span style="color:#9ca3af">= </span><span style="color:#86efac">0</span><span style="color:#9ca3af">;</span>

    <span style="color:#818cf8">public function</span> <span style="color:#fcd34d">increment</span><span style="color:#9ca3af">():</span> <span style="color:#818cf8">void</span>
    <span style="color:#9ca3af">{</span>
        <span style="color:#93c5fd">$this</span><span style="color:#9ca3af">-&gt;</span><span style="color:#93c5fd">count</span><span style="color:#9ca3af">++;</span>
    <span style="color:#9ca3af">}</span>

    <span style="color:#818cf8">public function</span> <span style="color:#fcd34d">decrement</span><span style="color:#9ca3af">():</span> <span style="color:#818cf8">void</span>
    <span style="color:#9ca3af">{</span>
        <span style="color:#93c5fd">$this</span><span style="color:#9ca3af">-&gt;</span><span style="color:#93c5fd">count</span><span style="color:#9ca3af">--;</span>
    <span style="color:#9ca3af">}</span>
<span style="color:#9ca3af">}</span></code></pre>
            </div>

        </div>

        {{-- PHP diff callout --}}
        <div class="reveal mt-4 flex items-center justify-center gap-3 text-sm" style="transition-delay:.15s">
            <span class="w-16 h-px bg-[#e8e5e1]"></span>
            <span class="inline-flex items-center gap-2 bg-white border border-[#e8e5e1] rounded-full px-4 py-1.5 text-[#6e6e73]">
                <span class="w-2 h-2 rounded-full bg-mw-500 shrink-0"></span>
                A familiar shape, adapted for Magento.
            </span>
            <span class="w-16 h-px bg-[#e8e5e1]"></span>
        </div>

        {{-- ── TEMPLATE COMPARISON ── --}}
        <div class="reveal flex items-center gap-4 mt-12 mb-4" style="transition-delay:.2s">
            <span class="text-xs font-mono font-medium text-[#9ca3af] uppercase tracking-widest">Template</span>
            <span class="flex-1 h-px bg-[#e8e5e1]"></span>
        </div>

        <div class="reveal grid md:grid-cols-2 gap-4 items-start" style="transition-delay:.25s">

            {{-- Blade template --}}
            <div class="rounded-2xl overflow-hidden border border-[#e8e5e1] shadow-sm">
                <div class="flex items-center bg-[#f5f3f0] px-5 py-3.5 border-b border-[#e8e5e1]">
                    <span class="text-sm font-semibold text-[#1d1d1f]">Laravel · Livewire</span>
                    <span class="ml-auto text-xs text-[#9ca3af] font-mono">counter.blade.php</span>
                </div>
<pre class="text-sm leading-relaxed p-5 font-mono overflow-x-auto bg-[#111110]"><code><span style="color:#9ca3af">&lt;div&gt;</span>

    <span style="color:#9ca3af">&lt;h2&gt;</span><span style="color:#a1a1aa">&#123;&#123;</span> <span style="color:#93c5fd">$count</span> <span style="color:#a1a1aa">&#125;&#125;</span><span style="color:#9ca3af">&lt;/h2&gt;</span>

    <span style="color:#9ca3af">&lt;button</span> <span style="color:#fb923c">wire:click</span><span style="color:#9ca3af">=</span><span style="color:#86efac">"decrement"</span><span style="color:#9ca3af">&gt;</span>&minus;<span style="color:#9ca3af">&lt;/button&gt;</span>
    <span style="color:#9ca3af">&lt;button</span> <span style="color:#fb923c">wire:click</span><span style="color:#9ca3af">=</span><span style="color:#86efac">"increment"</span><span style="color:#9ca3af">&gt;</span>+<span style="color:#9ca3af">&lt;/button&gt;</span>

<span style="color:#9ca3af">&lt;/div&gt;</span></code></pre>
            </div>

            {{-- PHTML template --}}
            <div class="rounded-2xl overflow-hidden border border-[#e8e5e1] shadow-sm">
                <div class="flex items-center bg-[#f5f3f0] px-5 py-3.5 border-b border-[#e8e5e1]">
                    <span class="text-sm font-semibold text-[#1d1d1f]">Magento&nbsp;2 · Magewire</span>
                    <span class="ml-auto text-xs text-[#9ca3af] font-mono">counter.phtml</span>
                </div>
<pre class="text-sm leading-relaxed p-5 font-mono overflow-x-auto bg-[#111110]"><code><span style="color:#9ca3af">&lt;div&gt;</span>

    <span style="color:#9ca3af">&lt;h2&gt;</span><span style="color:#a1a1aa">&#123;&#123;</span> <span style="color:#93c5fd">$magewire</span><span style="color:#9ca3af">-&gt;</span><span style="color:#93c5fd">count</span> <span style="color:#a1a1aa">&#125;&#125;</span><span style="color:#9ca3af">&lt;/h2&gt;</span>

    <span style="color:#9ca3af">&lt;button</span> <span style="color:#fb923c">wire:click</span><span style="color:#9ca3af">=</span><span style="color:#86efac">"decrement"</span><span style="color:#9ca3af">&gt;</span>&minus;<span style="color:#9ca3af">&lt;/button&gt;</span>
    <span style="color:#9ca3af">&lt;button</span> <span style="color:#fb923c">wire:click</span><span style="color:#9ca3af">=</span><span style="color:#86efac">"increment"</span><span style="color:#9ca3af">&gt;</span>+<span style="color:#9ca3af">&lt;/button&gt;</span>

<span style="color:#9ca3af">&lt;/div&gt;</span></code></pre>
            </div>

        </div>

        {{-- Template diff callout --}}
        <div class="reveal mt-4 flex items-center justify-center gap-3 text-sm" style="transition-delay:.3s">
            <span class="w-16 h-px bg-[#e8e5e1]"></span>
            <span class="inline-flex items-center gap-2 bg-white border border-[#e8e5e1] rounded-full px-4 py-1.5 text-[#6e6e73]">
                <span class="w-2 h-2 rounded-full bg-mw-500 shrink-0"></span>
                Familiar wire: directives, rendered in PHTML.
            </span>
            <span class="w-16 h-px bg-[#e8e5e1]"></span>
        </div>

        {{-- Alpine.js / Hyvä callout --}}
        <div class="reveal mt-10" style="transition-delay:.35s">
            <div class="sponsor-card rounded-2xl border border-mw-200 bg-mw-50 p-6 flex flex-col sm:flex-row items-start gap-5">
                <div class="shrink-0 w-11 h-11 rounded-xl border border-mw-200 bg-white flex items-center justify-center">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M3 20l5-8 4 5 3-4 6 7H3Z" stroke="#f26322" stroke-width="1.5" stroke-linejoin="round" fill="rgba(242,99,34,0.08)"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-[#1d1d1f] text-base mb-2">Alpine.js under the hood. Hyvä developers already know it.</p>
                    <p class="text-sm text-[#52525b] leading-relaxed">
                        Magewire's reactive layer runs on <a href="https://alpinejs.dev" target="_blank" rel="noopener" class="text-[#1d1d1f] font-semibold hover:text-mw-600 transition-colors">Alpine.js</a>, the same engine that powers <a href="https://hyva.io" target="_blank" rel="noopener" class="text-[#1d1d1f] font-semibold hover:text-mw-600 transition-colors">Hyvä Theme</a>. If you've built on Hyvä, you already speak Alpine.
                        <code class="font-mono text-mw-600 text-xs">x-data</code>,
                        <code class="font-mono text-mw-600 text-xs">x-on</code>,
                        <code class="font-mono text-mw-600 text-xs">@click</code>, all second nature. You're ahead before you write a line.
                    </p>
                    <p class="text-sm text-[#52525b] leading-relaxed mt-3">
                        <a href="https://alpinejs.dev" target="_blank" rel="noopener" class="text-[#1d1d1f] font-semibold hover:text-mw-600 transition-colors">Alpine.js</a> and <a href="https://livewire.laravel.com" target="_blank" rel="noopener" class="text-[#1d1d1f] font-semibold hover:text-mw-600 transition-colors">Livewire</a> share the same creator: <strong class="text-[#1d1d1f] font-semibold">Caleb Porzio</strong>. They don't just work well together; they were built for each other.
                    </p>
                </div>
            </div>
        </div>

        {{-- Three advantages --}}
        <div class="reveal grid sm:grid-cols-3 gap-4 mt-8" style="transition-delay:.4s">

            <div class="sponsor-card group flex flex-col gap-4 bg-white border border-[#e8e5e1] rounded-2xl p-6">
                <div class="w-10 h-10 rounded-xl bg-[#f5f3f0] border border-[#e8e5e1] flex items-center justify-center">
                    <svg class="w-5 h-5 text-mw-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84 51.39 51.39 0 0 0-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-[#1d1d1f] mb-1">Hit the ground running</p>
                    <p class="text-sm text-[#6e6e73] leading-relaxed">Livewire developers will recognize the component model and core directives immediately, leaving them to focus on Magento’s own conventions.</p>
                </div>
            </div>

            <div class="sponsor-card group flex flex-col gap-4 bg-white border border-[#e8e5e1] rounded-2xl p-6">
                <div class="w-10 h-10 rounded-xl bg-[#f5f3f0] border border-[#e8e5e1] flex items-center justify-center">
                    <svg class="w-5 h-5 text-mw-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-[#1d1d1f] mb-1">No invented abstractions</p>
                    <p class="text-sm text-[#6e6e73] leading-relaxed">The familiar pieces stay familiar on purpose, while Magento-specific behavior remains explicit where the platforms differ.</p>
                </div>
            </div>

            <div class="sponsor-card group flex flex-col gap-4 bg-white border border-[#e8e5e1] rounded-2xl p-6">
                <div class="w-10 h-10 rounded-xl bg-[#f5f3f0] border border-[#e8e5e1] flex items-center justify-center">
                    <svg class="w-5 h-5 text-mw-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253M3.157 7.582A8.959 8.959 0 0 0 3 12c0 .778.099 1.533.284 2.253"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-[#1d1d1f] mb-1">AI-ready, out of the box</p>
                    <p class="text-sm text-[#6e6e73] leading-relaxed">AI tools already understand many Livewire patterns, giving them useful context for Magewire while its Magento-specific docs remain the source of truth.</p>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- ══════════════════════════════════
     COMPATIBILITY
     ══════════════════════════════════ --}}
<section id="compatibility" class="py-36 px-6 bg-white">
    <div class="mx-auto max-w-6xl">

        <div class="reveal text-center mb-14">
            <span class="eyebrow">Platform &amp; theme support</span>
            <h2 class="text-5xl sm:text-6xl font-bold tracking-tight text-[#1a1a1a]">
                Compatibility
            </h2>
            <p class="mt-4 text-lg text-[#71717a] max-w-2xl mx-auto leading-relaxed">
                Supported platforms, runtimes, storefronts, and Magento areas for Magewire V3.
            </p>
        </div>

        <div class="reveal flex items-end justify-between gap-6 mb-5" style="transition-delay:.08s">
            <div>
                <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">Platforms &amp; runtime</span>
            </div>
            <p class="hidden text-sm text-[#8a8a90] sm:block">Minimum to current release</p>
        </div>

        <div class="reveal grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6" style="transition-delay:.12s">
            <a href="https://mage-os.org/product/releases/" target="_blank" rel="noopener"
               class="group overflow-hidden rounded-2xl border border-[#e8e5e1] bg-white shadow-[0_16px_45px_-34px_rgba(31,41,55,.35)] transition-all duration-300 hover:-translate-y-1 hover:border-mw-300 hover:shadow-[0_22px_55px_-34px_rgba(242,99,34,.32)]">
                <div class="aspect-square overflow-hidden bg-[#fff9f4]">
                    <img src="/images/compatibility/mage-os.webp"
                         alt="Abstract modular commerce foundation connected to a storefront and dashboard"
                         width="768" height="768" loading="lazy"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.035]">
                </div>
                <div class="p-4 sm:p-5">
                    <h4 class="font-bold leading-tight text-[#1d1d1f] sm:text-lg">Mage-OS</h4>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-green-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500" aria-hidden="true"></span>
                        Supported
                    </p>
                </div>
            </a>

            <a href="https://experienceleague.adobe.com/en/docs/commerce-operations/release/notes/magento-open-source/overview" target="_blank" rel="noopener"
               class="group overflow-hidden rounded-2xl border border-[#e8e5e1] bg-white shadow-[0_16px_45px_-34px_rgba(31,41,55,.35)] transition-all duration-300 hover:-translate-y-1 hover:border-mw-300 hover:shadow-[0_22px_55px_-34px_rgba(242,99,34,.32)]">
                <div class="aspect-square overflow-hidden bg-[#fff9f4]">
                    <img src="/images/compatibility/magento-open-source.webp"
                         alt="Abstract open commerce blueprint becoming a storefront"
                         width="768" height="768" loading="lazy"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.035]">
                </div>
                <div class="p-4 sm:p-5">
                    <h4 class="font-bold leading-tight text-[#1d1d1f] sm:text-lg">Magento Open Source</h4>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-green-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500" aria-hidden="true"></span>
                        Supported
                    </p>
                </div>
            </a>

            <a href="https://experienceleague.adobe.com/en/docs/commerce-operations/release/notes/adobe-commerce/overview" target="_blank" rel="noopener"
               class="group overflow-hidden rounded-2xl border border-[#e8e5e1] bg-white shadow-[0_16px_45px_-34px_rgba(31,41,55,.35)] transition-all duration-300 hover:-translate-y-1 hover:border-purple-300 hover:shadow-[0_22px_55px_-34px_rgba(126,34,206,.28)]">
                <div class="aspect-square overflow-hidden bg-[#fff9f4]">
                    <img src="/images/compatibility/adobe-commerce.webp"
                         alt="Abstract connected multi-store commerce platform"
                         width="768" height="768" loading="lazy"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.035]">
                </div>
                <div class="p-4 sm:p-5">
                    <h4 class="font-bold leading-tight text-[#1d1d1f] sm:text-lg">Adobe Commerce</h4>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-green-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500" aria-hidden="true"></span>
                        Supported
                    </p>
                </div>
            </a>

            <a href="https://packagist.org/packages/magewirephp/magewire" target="_blank" rel="noopener"
               class="group overflow-hidden rounded-2xl border border-[#e8e5e1] bg-white shadow-[0_16px_45px_-34px_rgba(31,41,55,.35)] transition-all duration-300 hover:-translate-y-1 hover:border-indigo-300 hover:shadow-[0_22px_55px_-34px_rgba(79,70,229,.28)]">
                <div class="aspect-square overflow-hidden bg-[#fff9f4]">
                    <img src="/images/compatibility/php.webp"
                         alt="Abstract PHP runtime connecting server logic to a storefront"
                         width="768" height="768" loading="lazy"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.035]">
                </div>
                <div class="p-4 sm:p-5">
                    <h4 class="font-bold leading-tight text-[#1d1d1f] sm:text-lg">PHP 8.2 - 8.5</h4>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-green-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500" aria-hidden="true"></span>
                        Supported
                    </p>
                </div>
            </a>
        </div>

        <div class="reveal mt-8 overflow-hidden rounded-3xl border border-[#e8e5e1] bg-[#fafaf8] shadow-[0_20px_60px_-48px_rgba(31,41,55,.4)]" style="transition-delay:.13s">
            <div class="flex flex-col gap-3 border-b border-[#e8e5e1] px-5 py-5 sm:flex-row sm:items-end sm:justify-between sm:px-7">
                <div>
                    <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">Compatibility matrix</span>
                    <p class="mt-1 text-sm text-[#71717a]">Supported Magewire V3 combinations</p>
                </div>
                <span class="text-xs font-semibold text-[#8a8a90]">7 combinations</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[780px] border-collapse text-left">
                    <thead>
                    <tr class="border-b border-[#e8e5e1] bg-white/70 text-xs font-bold uppercase tracking-[.12em] text-[#8a8a90]">
                        <th scope="col" class="px-7 py-4">Distribution</th>
                        <th scope="col" class="px-5 py-4">Version</th>
                        <th scope="col" class="px-5 py-4">PHP</th>
                        <th scope="col" class="px-7 py-4">Magento base / purpose</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-[#ece8e3] bg-white text-sm text-[#55555b]">
                    <tr>
                        <th scope="row" class="whitespace-nowrap px-7 py-4 font-semibold text-[#1d1d1f]">
                            <span class="mr-2 inline-block h-2.5 w-2.5 rounded-sm bg-[#f26322]" aria-hidden="true"></span>
                            Magento Open Source
                        </th>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">2.4.6-p15</td>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">8.2</td>
                        <td class="px-7 py-4">Oldest Magento line compatible with Magewire's PHP &ge;8.2</td>
                    </tr>
                    <tr>
                        <th scope="row" class="whitespace-nowrap px-7 py-4 font-semibold text-[#1d1d1f]">
                            <span class="mr-2 inline-block h-2.5 w-2.5 rounded-sm bg-[#f26322]" aria-hidden="true"></span>
                            Magento Open Source
                        </th>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">2.4.7-p10</td>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">8.3</td>
                        <td class="px-7 py-4">Current 2.4.7 patch line</td>
                    </tr>
                    <tr>
                        <th scope="row" class="whitespace-nowrap px-7 py-4 font-semibold text-[#1d1d1f]">
                            <span class="mr-2 inline-block h-2.5 w-2.5 rounded-sm bg-[#f26322]" aria-hidden="true"></span>
                            Magento Open Source
                        </th>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">2.4.8-p5</td>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">8.4</td>
                        <td class="px-7 py-4">Current 2.4.8 patch line</td>
                    </tr>
                    <tr>
                        <th scope="row" class="whitespace-nowrap px-7 py-4 font-semibold text-[#1d1d1f]">
                            <span class="mr-2 inline-block h-2.5 w-2.5 rounded-sm bg-[#f26322]" aria-hidden="true"></span>
                            Magento Open Source
                        </th>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">2.4.9</td>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">8.5</td>
                        <td class="px-7 py-4">Latest Magento with latest PHP</td>
                    </tr>
                    <tr class="border-t-2 border-t-[#ded8d1]">
                        <th scope="row" class="whitespace-nowrap px-7 py-4 font-semibold text-[#1d1d1f]">
                            <span class="mr-2 inline-block h-2.5 w-2.5 rounded-full bg-[#ff9234] ring-2 ring-[#ffe0c7]" aria-hidden="true"></span>
                            Mage-OS
                        </th>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">1.3.1</td>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">8.2</td>
                        <td class="px-7 py-4">Magento 2.4.8-p2 base; Magewire PHP floor</td>
                    </tr>
                    <tr>
                        <th scope="row" class="whitespace-nowrap px-7 py-4 font-semibold text-[#1d1d1f]">
                            <span class="mr-2 inline-block h-2.5 w-2.5 rounded-full bg-[#ff9234] ring-2 ring-[#ffe0c7]" aria-hidden="true"></span>
                            Mage-OS
                        </th>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">2.3.0</td>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">8.4</td>
                        <td class="px-7 py-4">Magento 2.4.8-p5 base</td>
                    </tr>
                    <tr>
                        <th scope="row" class="whitespace-nowrap px-7 py-4 font-semibold text-[#1d1d1f]">
                            <span class="mr-2 inline-block h-2.5 w-2.5 rounded-full bg-[#ff9234] ring-2 ring-[#ffe0c7]" aria-hidden="true"></span>
                            Mage-OS
                        </th>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">3.2.0</td>
                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-[#343438]">8.5</td>
                        <td class="px-7 py-4">Magento 2.4.9 base; latest/latest</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="reveal mt-16 mb-5 border-t border-[#eeeae6] pt-12" style="transition-delay:.14s">
            <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">Themes</span>
        </div>

        <div class="reveal grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6" style="transition-delay:.15s">

            <a href="https://github.com/magewirephp/magewire-admin" target="_blank" rel="noopener"
               class="group overflow-hidden rounded-2xl border border-[#e8e5e1] bg-white shadow-[0_16px_45px_-34px_rgba(31,41,55,.35)] transition-all duration-300 hover:-translate-y-1 hover:border-green-300 hover:shadow-[0_22px_55px_-34px_rgba(22,163,74,.35)]">
                <div class="aspect-square overflow-hidden bg-[#fff9f4]">
                    <img src="/images/compatibility/backend.webp"
                         alt="Abstract supported administration dashboard"
                         width="768" height="768" loading="lazy"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.035]">
                </div>
                <div class="p-4 text-center sm:p-5">
                    <h3 class="font-bold leading-tight text-[#1d1d1f] sm:text-lg">Magento Backend</h3>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-green-700 sm:text-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500" aria-hidden="true"></span>
                        Supported
                    </p>
                </div>
            </a>

            <a href="https://github.com/magewirephp/magewire-hyva-theme" target="_blank" rel="noopener" class="group overflow-hidden rounded-2xl border border-[#e8e5e1] bg-white shadow-[0_16px_45px_-34px_rgba(31,41,55,.35)] transition-all duration-300 hover:-translate-y-1 hover:border-green-300 hover:shadow-[0_22px_55px_-34px_rgba(22,163,74,.35)]">
                <div class="aspect-square overflow-hidden bg-[#fff9f4]">
                    <img src="/images/compatibility/hyva.webp"
                         alt="Abstract fast storefront with a support check"
                         width="768" height="768" loading="lazy"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.035]">
                </div>
                <div class="p-4 text-center sm:p-5">
                    <h3 class="font-bold leading-tight text-[#1d1d1f] sm:text-lg">Hyvä</h3>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-green-700 sm:text-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500" aria-hidden="true"></span>
                        Supported
                    </p>
                </div>
            </a>

            <div class="group overflow-hidden rounded-2xl border border-[#e8e5e1] bg-white shadow-[0_16px_45px_-34px_rgba(31,41,55,.35)] transition-all duration-300 hover:-translate-y-1 hover:border-amber-300 hover:shadow-[0_22px_55px_-34px_rgba(217,119,6,.3)]">
                <div class="aspect-square overflow-hidden bg-[#fffbf3]">
                    <img src="/images/compatibility/breeze.webp"
                         alt="Abstract storefront components moving through an incomplete progress loop"
                         width="768" height="768" loading="lazy"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.035]">
                </div>
                <div class="p-4 text-center sm:p-5">
                    <h3 class="font-bold leading-tight text-[#1d1d1f] sm:text-lg">Breeze</h3>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 sm:text-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-400" aria-hidden="true"></span>
                        In progress · Community
                    </p>
                </div>
            </div>

            <div class="group overflow-hidden rounded-2xl border border-[#e8e5e1] bg-white shadow-[0_16px_45px_-34px_rgba(31,41,55,.35)] transition-all duration-300 hover:-translate-y-1 hover:border-[#d6d3d1] hover:shadow-[0_22px_55px_-34px_rgba(87,83,78,.3)]">
                <div class="aspect-square overflow-hidden bg-[#faf8f5]">
                    <img src="/images/compatibility/luma.webp"
                         alt="Abstract storefront with a calm pause symbol and disconnected plug"
                         width="768" height="768" loading="lazy"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.035]">
                </div>
                <div class="p-4 text-center sm:p-5">
                    <h3 class="font-bold leading-tight text-[#1d1d1f] sm:text-lg">Luma</h3>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-[#78716c] sm:text-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#a8a29e]" aria-hidden="true"></span>
                        No active plans
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>


{{-- ══════════════════════════════════
     SPONSORS
     ══════════════════════════════════ --}}
<section id="sponsors" class="py-36 px-6 bg-[#fafaf8]">
    <div class="mx-auto max-w-5xl">

        <div class="reveal text-center mb-16">
            <span class="eyebrow">Open Source</span>
            <h2 class="text-5xl sm:text-6xl font-bold tracking-tight text-[#1a1a1a]">
                Sponsors
            </h2>
            <p class="mt-4 text-lg text-[#71717a] max-w-2xl mx-auto leading-relaxed">
                Free and open source. Kept running by these generous sponsors.
            </p>
        </div>

        <div class="reveal grid sm:grid-cols-2 gap-6 mb-8" style="transition-delay:.15s">

            <a href="https://vendic.nl" target="_blank" rel="noopener sponsored"
               class="sponsor-card group rounded-2xl border border-[#e8e5e1] bg-white
                      p-8 flex flex-col items-center text-center gap-5">
                <img src="https://vendic.nl/img/logo.svg"
                     alt="Vendic" class="h-10 w-auto" loading="lazy">
                <p class="text-base text-[#6e6e73]">Magento &amp; Hyvä agency from the Netherlands</p>
            </a>

            <a href="https://zero1.co.uk" target="_blank" rel="noopener sponsored"
               class="sponsor-card group rounded-2xl border border-[#e8e5e1] bg-white
                      p-8 flex flex-col items-center text-center gap-5">
                <img src="https://www.zero1.co.uk/static/version1769734989/frontend/z1/hyva/en_GB/images/logo.svg"
                     alt="Zero 1" class="h-10 w-auto" loading="lazy">
                <p class="text-base text-[#6e6e73]">Ecommerce agency &amp; Magento specialists, UK</p>
            </a>

        </div>

        <div class="rounded-2xl border border-[#f0ece7] bg-[#fffaf7]
                    p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <p class="text-lg font-semibold text-[#1a1a1a]">Become a sponsor</p>
            </div>
            <a href="https://github.com/sponsors/wpoortman"
               target="_blank" rel="noopener"
               class="shrink-0 inline-flex items-center gap-2 bg-mw-500 hover:bg-mw-600
                      text-white font-semibold text-sm px-6 py-3 rounded-full
                      transition-colors shadow-md shadow-mw-200/60">
                Sponsor on GitHub
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                     viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>

        {{-- Contributors --}}
        <div class="reveal mt-24 text-center mb-12">
            <span class="eyebrow">Built by the community</span>
            <h2 class="text-4xl sm:text-5xl font-bold tracking-tight text-[#1a1a1a]">
                Contributors
            </h2>
            <p class="mt-4 text-lg text-[#71717a] max-w-2xl mx-auto leading-relaxed">
                Every commit, fix, and bright idea traces back to these people and the teams who champion Magewire as their own.
            </p>
        </div>

        {{-- People --}}
        @php
            $contributors = [
                ['handle' => 'wpoortman',      'name' => 'Willem Poortman'],
                ['handle' => 'Vinai',          'name' => 'Vinai Kopp'],
                ['handle' => 'pykettk',        'name' => 'Kiel'],
                ['handle' => 'Tjitse-E',       'name' => 'Tjitse'],
                ['handle' => 'ryanhissey',     'name' => 'Ryan Hissey'],
                ['handle' => 'adamzero1',      'name' => 'Adam'],
                ['handle' => 'angelvilaplana', 'name' => 'Angel Vilaplana'],
                ['handle' => 'speedupmate',    'name' => 'Anton Siniorg'],
                ['handle' => 'alucardatem',    'name' => 'Dan-Andrei Rotariu'],
                ['handle' => 'quanghien95',    'name' => 'Jacob'],
                ['handle' => 'JeroenBoersma',  'name' => 'Jeroen Boersma'],
                ['handle' => 'jeroennoten',    'name' => 'Jeroen Noten'],
                ['handle' => 'jissereitsma',   'name' => 'Jisse Reitsma'],
                ['handle' => 'KamilBalwierz',  'name' => 'Kamil Balwierz'],
                ['handle' => 'ProxiBlue',      'name' => 'Lucas van Staden'],
                ['handle' => 'markshust',      'name' => 'Mark Shust'],
                ['handle' => 'MartinNguyen211','name' => 'Martin Nguyen'],
                ['handle' => 'mehmetuygun',    'name' => 'Mehmet Uygun'],
                ['handle' => 'psopacua',       'name' => 'Pascal Sopacua'],
                ['handle' => 'peterjaap',      'name' => 'Peter Jaap Blaakmeer'],
                ['handle' => 'hostep',         'name' => 'Pieter Hoste'],
                ['handle' => 'rossmc',         'name' => 'Ross'],
                ['handle' => 'Morgy93',        'name' => 'Thomas Hauschild'],
                ['handle' => 'kolaente',       'name' => 'kolaente'],
                ['handle' => 'mvenghaus',      'name' => 'mvenghaus'],
            ];
        @endphp
        <h3 class="reveal text-center text-sm font-semibold uppercase tracking-wide text-[#9ca3af] mb-6">People</h3>
        <div class="reveal flex flex-wrap justify-center gap-6 mb-16" style="transition-delay:.15s">
            @foreach ($contributors as $c)
                <a href="https://github.com/{{ $c['handle'] }}" target="_blank" rel="noopener"
                   class="group flex flex-col items-center gap-2 w-20"
                   title="{{ $c['name'] }} (@{{ $c['handle'] }})">
                    <img src="https://github.com/{{ $c['handle'] }}.png?size=96"
                         alt="{{ $c['name'] }}" loading="lazy"
                         class="h-14 w-14 rounded-full ring-2 ring-transparent group-hover:ring-mw-400 transition-all">
                    <span class="text-xs text-[#71717a] group-hover:text-mw-600 transition-colors truncate max-w-full">{{ $c['name'] }}</span>
                </a>
            @endforeach
        </div>

        {{-- Companies backing Magewire --}}
        <h3 class="reveal text-center text-sm font-semibold uppercase tracking-wide text-[#9ca3af] mb-6">Organizations</h3>
        <div class="reveal flex flex-wrap justify-center gap-6" style="transition-delay:.15s">
            <a href="https://hyva.io" target="_blank" rel="noopener"
               class="group flex flex-col items-center gap-2 w-20"
               title="Hyvä Themes">
                <img src="https://www.hyva.io/media/favicon/stores/1/Favicon.png"
                     alt="Hyvä Themes" loading="lazy"
                     class="h-14 w-14 rounded-full ring-2 ring-transparent group-hover:ring-mw-400 transition-all">
                <span class="text-xs text-[#71717a] group-hover:text-mw-600 transition-colors truncate max-w-full">Hyvä</span>
            </a>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════
     MAGEWIRE IN THE WILD
     ══════════════════════════════════ --}}
<section class="py-36 px-6 bg-white">
    <div class="mx-auto max-w-5xl">

        <div class="reveal text-center mb-16">
            <span class="eyebrow">Real-world adoption</span>
            <h2 class="text-5xl sm:text-6xl font-bold tracking-tight text-[#1a1a1a]">
                Magewire in the wild.
            </h2>
            <p class="mt-4 text-lg text-[#71717a] max-w-2xl mx-auto leading-relaxed">
                Two Hyvä products. Two different relationships with Magewire.
            </p>
        </div>

        <div class="reveal grid md:grid-cols-2 gap-6" style="transition-delay:.15s">

            {{-- Hyvä Checkout --}}
            <a href="https://www.hyva.io/hyva-checkout.html" target="_blank" rel="noopener"
               class="group overflow-hidden rounded-[28px] border border-[#e8e5e1] bg-white shadow-[0_18px_55px_-35px_rgba(31,41,55,.35)] transition-all duration-300 hover:-translate-y-1 hover:border-green-300 hover:shadow-[0_24px_65px_-35px_rgba(22,163,74,.4)]">
                <div class="aspect-[3/2] overflow-hidden bg-[#fff9f4]">
                    <img src="/images/hyva/checkout.webp"
                         alt="Abstract checkout steps flowing into a completed order"
                         width="1536" height="1024" loading="lazy"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.025]">
                </div>

                <div class="flex items-center justify-between gap-5 p-6 sm:p-7">
                    <div>
                        <h3 class="text-xl font-bold tracking-tight text-[#1d1d1f]">Hyvä Checkout</h3>
                        <p class="mt-1.5 text-sm font-medium text-green-700">Powered by Magewire · V1 + V3</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-green-50 text-green-700 transition-colors group-hover:bg-green-600 group-hover:text-white" aria-hidden="true">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>
                    </span>
                </div>
            </a>

            {{-- Hyvä CMS --}}
            <a href="https://www.hyva.io/hyva-commerce.html" target="_blank" rel="noopener"
               class="group overflow-hidden rounded-[28px] border border-[#e8e5e1] bg-white shadow-[0_18px_55px_-35px_rgba(31,41,55,.35)] transition-all duration-300 hover:-translate-y-1 hover:border-purple-300 hover:shadow-[0_24px_65px_-35px_rgba(126,34,206,.35)]">
                <div class="aspect-[3/2] overflow-hidden bg-[#fbf8ff]">
                    <img src="/images/hyva/cms.webp"
                         alt="Abstract content blocks assembling into a storefront"
                         width="1536" height="1024" loading="lazy"
                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.025]">
                </div>

                <div class="flex items-center justify-between gap-5 p-6 sm:p-7">
                    <div>
                        <h3 class="text-xl font-bold tracking-tight text-[#1d1d1f]">Hyvä CMS with Liveview</h3>
                        <p class="mt-1.5 text-sm font-medium text-purple-700">Built on a tailored Magewire fork</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-purple-50 text-purple-700 transition-colors group-hover:bg-purple-600 group-hover:text-white" aria-hidden="true">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>
                    </span>
                </div>
            </a>

        </div>

        {{-- Suggest a project callout --}}
        <div class="reveal mt-10" style="transition-delay:.3s">
            <div class="sponsor-card rounded-2xl border border-mw-200 bg-mw-50 p-6 flex flex-col sm:flex-row items-start gap-5">
                <div class="shrink-0 w-11 h-11 rounded-xl border border-mw-200 bg-white flex items-center justify-center">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#f26322" stroke-width="1.6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.183-.498c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-[#1d1d1f] text-base mb-2">Know an awesome project built on Magewire?</p>
                    <p class="text-sm text-[#52525b] leading-relaxed">
                        We'd love to feature it here.
                        <a href="https://github.com/magewirephp/magewire/discussions" target="_blank" rel="noopener" class="text-[#1d1d1f] font-semibold hover:text-mw-600 transition-colors">Start a discussion on GitHub</a>
                        and let's make it happen.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════
     FOOTER
     ══════════════════════════════════ --}}
<footer class="bg-[#0f0f0e] px-6 py-16">
    <div class="mx-auto max-w-5xl flex flex-col md:flex-row items-center justify-between gap-8">
        <span class="text-base font-bold text-[#9ca3af]">MagewirePHP</span>
        <nav aria-label="Footer" class="flex flex-wrap items-center justify-center gap-6">
            <a href="https://docs.magewirephp.nl/?ref=main-website"
               target="_blank" rel="noopener"
               class="text-base text-[#9ca3af] hover:text-white transition-colors">Docs</a>
            <a href="https://docs.magewirephp.nl/blogs/?ref=main-website"
               target="_blank" rel="noopener"
               class="text-base text-[#9ca3af] hover:text-white transition-colors">Blog</a>
            <a href="https://github.com/magewirephp/magewire"
               target="_blank" rel="noopener"
               class="text-base text-[#9ca3af] hover:text-white transition-colors">GitHub</a>
            <a href="{{ route('why') }}"
               class="text-base text-[#9ca3af] hover:text-white transition-colors">Why</a>
            <a href="https://github.com/sponsors/wpoortman"
               target="_blank" rel="noopener"
               class="text-base text-[#9ca3af] hover:text-white transition-colors">Sponsors</a>
            <a href="https://discord.gg/magewire"
               target="_blank" rel="noopener"
               class="text-base text-[#9ca3af] hover:text-white transition-colors">Discord</a>
        </nav>
        <p class="text-sm text-[#9ca3af]">
            MIT License &middot; &copy; {{ date('Y') }} MagewirePHP
        </p>
    </div>
</footer>

</main>

@fluxScripts

<script>
    // Nav glass on scroll
    const nav = document.getElementById('site-nav');
    function updateNav() {
        nav.classList.toggle('nav-solid', window.scrollY > 12);
    }
    window.addEventListener('scroll', updateNav, { passive: true });
    updateNav();

    // Scroll-triggered reveal
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
</script>

</body>
</html>
