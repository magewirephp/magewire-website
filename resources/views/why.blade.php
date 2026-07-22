<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Why Magewire | MagewirePHP</title>
    <meta name="description" content="Why Magewire brings Livewire's proven developer experience to Magento, including its familiar syntax, performance tradeoffs, and open-source purpose.">

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
        .paper-grid {
            background-image: radial-gradient(circle, rgba(180, 161, 148, .52) 1.1px, transparent 1.1px);
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
            <a href="{{ url('/') }}#install" class="nav-link">Install</a>
            <a href="{{ url('/') }}#compatibility" class="nav-link">Compatibility</a>
            <a href="{{ route('why') }}" class="nav-link active" aria-current="page">Why</a>
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
            <button @click="menu = !menu" :aria-expanded="menu" aria-controls="why-mobile-menu"
                    class="flex h-9 w-9 items-center justify-center rounded-full border border-[#d2d2d7] text-[#52525b] transition-colors hover:border-mw-500 hover:text-mw-600 md:hidden"
                    aria-label="Toggle navigation menu">
                <svg x-show="!menu" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-show="menu" x-cloak width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
    </div>

    <nav id="why-mobile-menu" x-show="menu" x-cloak x-transition.opacity aria-label="Mobile" class="border-t border-[#e8e5e1] bg-white/95 md:hidden">
        <div class="mx-auto flex max-w-6xl flex-col px-6 py-3">
            <a href="https://docs.magewirephp.nl/?ref=main-website" target="_blank" rel="noopener" class="border-b border-[#f0ece7] py-3 font-medium">Docs</a>
            <a href="{{ url('/') }}#install" class="border-b border-[#f0ece7] py-3 font-medium">Install</a>
            <a href="{{ url('/') }}#compatibility" class="border-b border-[#f0ece7] py-3 font-medium">Compatibility</a>
            <a href="{{ route('why') }}" class="border-b border-[#f0ece7] py-3 font-semibold text-mw-600" aria-current="page">Why</a>
            <a href="{{ url('/') }}#sponsors" class="border-b border-[#f0ece7] py-3 font-medium">Sponsors</a>
            <a href="https://docs.magewirephp.nl/blogs/?ref=main-website" target="_blank" rel="noopener" class="py-3 font-medium">Blog</a>
        </div>
    </nav>
</header>

<main id="main">
    <section class="relative overflow-hidden border-b border-[#e9e5e0] px-6 py-20 sm:py-28">
        <div class="paper-grid absolute inset-0 opacity-40" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_72%_60%_at_50%_0%,rgba(242,99,34,0.18),transparent_72%)]" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-5xl">
            <div class="max-w-4xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-mw-200 bg-white/80 px-4 py-2 text-xs font-bold uppercase tracking-[.14em] text-mw-700 shadow-sm">
                    <span class="h-1.5 w-1.5 rounded-full bg-mw-500" aria-hidden="true"></span>
                    Why Magewire
                </span>
                <h1 class="mt-8 text-5xl font-black leading-[.98] tracking-[-.055em] text-[#181817] sm:text-7xl lg:text-[5.5rem]">
                    Reactive Magento.<br>
                    <span class="text-mw-500">Familiar by design.</span>
                </h1>
                <p class="mt-8 max-w-3xl text-xl font-medium leading-relaxed text-[#55555b] sm:text-2xl">
                    Magewire brings the component-driven developer experience popularized by Laravel Livewire to Magento. It is adapted to the platform, honest about its differences, and focused on keeping interactive work understandable.
                </p>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 sm:py-24">
        <div class="mx-auto grid max-w-5xl gap-10 md:grid-cols-[.7fr_1.3fr] md:gap-16">
            <div>
                <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">Why it started</span>
                <h2 class="mt-4 text-3xl font-bold tracking-[-.04em] text-[#1d1d1f] sm:text-4xl">The wheel was already round.</h2>
            </div>
            <div class="space-y-5 text-lg leading-relaxed text-[#626267]">
                <p>
                    Magewire started because Livewire had already proven that server-driven components can make reactive interfaces simpler to build. That proof was the reason the port was worth starting in the first place. The goal was never to invent another frontend philosophy.
                </p>
                <p>
                    This is why the names, syntax, and mental model stay familiar. Developers get less to learn, teams get less to explain, and Magento keeps its own architecture. Sometimes the friendliest new idea is knowing which parts do not need reinventing.
                </p>
            </div>
        </div>
    </section>

    <section class="border-y border-[#e9e5e0] bg-white px-6 py-20 sm:py-24">
        <div class="mx-auto max-w-6xl">
            <div class="grid gap-12 lg:grid-cols-[.8fr_1.2fr] lg:gap-20">
                <div>
                    <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">Familiar on purpose</span>
                    <h2 class="mt-5 text-4xl font-bold tracking-[-.045em] text-[#1d1d1f] sm:text-5xl">
                        Livewire familiarity is deliberate.
                    </h2>
                    <p class="mt-6 text-lg leading-relaxed text-[#6e6e73]">
                        Magewire is strongly inspired by Laravel Livewire. Its component model made server-driven interfaces feel natural in PHP, and that familiarity is useful, not something to rename or disguise.
                    </p>
                    <p class="mt-5 text-lg leading-relaxed text-[#6e6e73]">
                        Public state, component actions, lifecycle ideas, and <code class="rounded bg-mw-50 px-1.5 py-0.5 font-mono text-sm text-mw-700">wire:</code> directives follow the same mental model. Livewire developers should recognize Magewire quickly.
                    </p>
                </div>

                <div class="overflow-hidden rounded-3xl border border-[#34343a] bg-[#111318] shadow-2xl shadow-black/20">
                    <div class="flex items-center justify-between border-b border-white/10 bg-[#1b1d23] px-5 py-4">
                        <span class="text-sm font-semibold text-white">The familiar part</span>
                        <span class="font-mono text-xs text-[#8f939d]">Counter.php</span>
                    </div>
                    <div class="grid md:grid-cols-2">
                        <div class="border-b border-white/10 p-6 md:border-b-0 md:border-r">
                            <div class="mb-5 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-[#a5a8b0]">
                                <span class="h-2 w-2 rounded-full bg-[#fb70a9]"></span>
                                Livewire
                            </div>
<pre class="code-scroll overflow-x-auto font-mono text-[13px] leading-7 text-[#d7dae0]"><code><span class="text-[#c792ea]">use</span> <span class="text-[#89ddff]">Livewire\Component</span>;

<span class="text-[#c792ea]">class</span> <span class="text-[#ffcb6b]">Counter</span> <span class="text-[#c792ea]">extends</span> Component
{
    <span class="text-[#c792ea]">public int</span> <span class="text-[#82aaff]">$count</span> = <span class="text-[#f78c6c]">0</span>;

    <span class="text-[#c792ea]">public function</span> <span class="text-[#ffcb6b]">increment</span>(): <span class="text-[#89ddff]">void</span>
    {
        <span class="text-[#82aaff]">$this</span>-&gt;count++;
    }
}</code></pre>
                        </div>
                        <div class="p-6">
                            <div class="mb-5 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-[#a5a8b0]">
                                <span class="h-2 w-2 rounded-full bg-mw-400"></span>
                                Magewire
                            </div>
<pre class="code-scroll overflow-x-auto font-mono text-[13px] leading-7 text-[#d7dae0]"><code><span class="text-[#c792ea]">use</span> <span class="text-[#89ddff]">Magewire\Component</span>;

<span class="text-[#c792ea]">class</span> <span class="text-[#ffcb6b]">Counter</span> <span class="text-[#c792ea]">extends</span> Component
{
    <span class="text-[#c792ea]">public int</span> <span class="text-[#82aaff]">$count</span> = <span class="text-[#f78c6c]">0</span>;

    <span class="text-[#c792ea]">public function</span> <span class="text-[#ffcb6b]">increment</span>(): <span class="text-[#89ddff]">void</span>
    {
        <span class="text-[#82aaff]">$this</span>-&gt;count++;
    }
}</code></pre>
                        </div>
                    </div>
                    <div class="border-t border-white/10 bg-[#17191f] px-6 py-4 font-mono text-sm text-[#b7bac2]">
                        &lt;button <span class="text-mw-400">wire:click</span>=<span class="text-[#c3e88d]">&quot;increment&quot;</span>&gt;Add one&lt;/button&gt;
                    </div>
                </div>
            </div>

            <div class="mt-12 rounded-2xl border border-amber-200 bg-amber-50/70 p-7 sm:flex sm:items-start sm:gap-5">
                <span class="mb-4 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-amber-700 shadow-sm sm:mb-0" aria-hidden="true">≈</span>
                <div>
                    <h3 class="font-bold text-[#282824]">Familiar does not mean identical.</h3>
                    <p class="mt-2 leading-relaxed text-[#6d665d]">
                        Magewire is shaped by Magento’s layout system, rendering lifecycle, dependency injection, caching, and storefront realities. Some Livewire features work differently; some are not supported yet. The syntax and mental model stay close, but Magewire does not claim perfect parity.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 sm:py-24">
        <div class="mx-auto max-w-6xl">
            <div class="max-w-3xl">
                <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">The performance question</span>
                <h2 class="mt-5 text-4xl font-bold tracking-[-.045em] text-[#1d1d1f] sm:text-5xl">
                    Yes, an HTTP request has a cost.
                </h2>
                <p class="mt-6 text-lg leading-relaxed text-[#6e6e73]">
                    Skepticism is reasonable. A reactive Magewire action can make an HTTP request, and bootstrapping Magento is not free. That cost should be understood, measured, and avoided when the server adds no value.
                </p>
            </div>

            <div class="mt-12 grid gap-5 md:grid-cols-2">
                <article class="rounded-3xl border border-[#e7e3de] bg-white p-8">
                    <span class="font-mono text-xs font-bold text-[#71717a]">THE CONCERN</span>
                    <h3 class="mt-5 text-2xl font-bold">Server work can be expensive</h3>
                    <p class="mt-3 leading-relaxed text-[#71717a]">
                        On a busy Magento store, unnecessary round trips add latency and load. Magewire does not make that concern disappear, and it should not be used as an excuse to stop thinking about architecture.
                    </p>
                </article>
                <article class="rounded-3xl border border-mw-200 bg-mw-50 p-8">
                    <span class="font-mono text-xs font-bold text-mw-700">THE V3 DIRECTION</span>
                    <h3 class="mt-5 text-2xl font-bold">Keep more on the client</h3>
                    <p class="mt-3 leading-relaxed text-[#6f625b]">
                        Magewire V3 increasingly keeps state and behavior in the browser. It tends to contact the server only when PHP, authoritative data, or Magento services are actually needed.
                    </p>
                </article>
            </div>

            <div class="mt-6 rounded-3xl bg-[#171715] p-8 text-white sm:p-10">
                <div class="grid gap-8 lg:grid-cols-[1fr_1.2fr] lg:items-center">
                    <h3 class="text-3xl font-bold tracking-[-.035em] sm:text-4xl">
                        Where should the complexity live?
                    </h3>
                    <div class="space-y-4 text-lg leading-relaxed text-[#c5c5c3]">
                        <p>
                            Fewer requests can mean more client-side state, duplicated rules, API plumbing, and JavaScript to maintain. A selective request can keep the source of truth in PHP and make the feature much simpler to understand.
                        </p>
                        <p class="font-semibold text-white">
                            Neither choice is universally correct. Magewire’s position is that a small, intentional request cost is often a good trade when it removes substantial complexity.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-t border-[#e9e5e0] bg-white px-6 py-20 sm:py-24">
        <div class="mx-auto grid max-w-6xl gap-12 lg:grid-cols-[1.1fr_.9fr] lg:gap-20">
            <div>
                <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">Open source and community</span>
                <h2 class="mt-5 text-4xl font-bold tracking-[-.045em] text-[#1d1d1f] sm:text-5xl">
                    New ideas belong in Magento too.
                </h2>
                <div class="mt-6 space-y-5 text-lg leading-relaxed text-[#6e6e73]">
                    <p>
                        Magewire is a practical tool, but it is also evidence that this community keeps experimenting. It shows developers inside and outside Magento that modern technology and better developer experience are being pursued here.
                    </p>
                    <p>
                        Maintaining open source takes more time than it returns. The point is not recognition; it is useful software and shared progress. Sponsors make that work more sustainable, and we appreciate the companies that choose to give back rather than only consume.
                    </p>
                </div>
            </div>

            <aside class="rounded-3xl border border-[#e7e3de] bg-[#fafaf8] p-8 sm:p-10">
                <h3 class="text-xl font-bold">Supported by</h3>
                <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                    <a href="https://vendic.nl" target="_blank" rel="noopener sponsored" class="rounded-xl border border-[#e7e3de] bg-white px-5 py-4 font-bold transition-colors hover:border-mw-300 hover:text-mw-600">Vendic</a>
                    <a href="https://zero1.co.uk" target="_blank" rel="noopener sponsored" class="rounded-xl border border-[#e7e3de] bg-white px-5 py-4 font-bold transition-colors hover:border-mw-300 hover:text-mw-600">Zero 1</a>
                </div>
                <a href="https://github.com/sponsors/wpoortman" target="_blank" rel="noopener"
                   class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-mw-600 transition-colors hover:text-mw-700">
                    Sponsor Magewire
                    <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M3 8h10m-3-3 3 3-3 3"/></svg>
                </a>
            </aside>
        </div>

        <div class="mx-auto mt-16 flex max-w-6xl flex-col items-start justify-between gap-6 border-t border-[#e7e3de] pt-10 sm:flex-row sm:items-center">
            <p class="max-w-2xl text-xl font-bold tracking-tight text-[#1d1d1f]">
                Magewire favors understandable systems, measured tradeoffs, and a better day-to-day developer experience.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="https://docs.magewirephp.nl/?ref=main-website" target="_blank" rel="noopener" class="rounded-full bg-mw-500 px-5 py-3 text-sm font-bold text-white transition-colors hover:bg-mw-600">Read the docs</a>
                <a href="https://github.com/magewirephp/magewire" target="_blank" rel="noopener" class="rounded-full border border-[#d9d6d1] bg-white px-5 py-3 text-sm font-bold text-[#3f3f46] transition-colors hover:border-mw-300 hover:text-mw-600">View on GitHub</a>
            </div>
        </div>
    </section>
</main>

<footer class="bg-[#0f0f0e] px-6 py-12">
    <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-7 md:flex-row">
        <a href="/" class="font-bold text-[#d1d5db] transition-colors hover:text-white">MagewirePHP</a>
        <nav aria-label="Footer" class="flex flex-wrap items-center justify-center gap-6">
            <a href="{{ route('why') }}" class="text-sm text-white">Why</a>
            <a href="https://docs.magewirephp.nl/?ref=main-website" target="_blank" rel="noopener" class="text-sm text-[#9ca3af] hover:text-white">Docs</a>
            <a href="https://github.com/magewirephp/magewire" target="_blank" rel="noopener" class="text-sm text-[#9ca3af] hover:text-white">GitHub</a>
            <a href="https://discord.gg/magewire" target="_blank" rel="noopener" class="text-sm text-[#9ca3af] hover:text-white">Discord</a>
        </nav>
        <p class="text-sm text-[#73737a]">MIT License &middot; &copy; {{ date('Y') }}</p>
    </div>
</footer>

</body>
</html>
