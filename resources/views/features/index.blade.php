<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Compiler — Magewire Features</title>
    <meta name="description" content="Discover Magewire's template compiler: expressive PHTML syntax, safe output, automatic recompilation, and extensible directives for Magento 2.">

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

    <style>
        :root { --color-accent: #f26322; }
        [x-cloak] { display: none !important; }
        :focus-visible { outline: 2px solid #f26322; outline-offset: 3px; border-radius: 4px; }
        .nav-link {
            font-size: .9375rem;
            font-weight: 500;
            color: #52525b;
            padding: .375rem .75rem;
            border-radius: 9999px;
            transition: color .15s, background .15s;
        }
        .nav-link:hover, .nav-link.active { color: #e04e0f; background: #fff4ee; }
        .dot-grid {
            background-image: radial-gradient(circle, rgba(180, 161, 148, .6) 1.2px, transparent 1.2px);
            background-size: 28px 28px;
        }
        .code-scroll::-webkit-scrollbar { height: 5px; }
        .code-scroll::-webkit-scrollbar-track { background: transparent; }
        .code-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.16); border-radius: 99px; }
        .feature-card { transition: transform .2s, box-shadow .2s, border-color .2s; }
        .feature-card:hover { transform: translateY(-2px); border-color: #ffc9a6; box-shadow: 0 16px 40px -24px rgba(73, 43, 25, .28); }
    </style>
</head>
<body class="bg-[#fafaf8] text-[#1a1a1a] antialiased font-sans overflow-x-hidden">

<a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[9999] focus:bg-mw-500 focus:text-white focus:px-4 focus:py-2 focus:rounded-xl focus:font-semibold">
    Skip to main content
</a>

<header role="banner" x-data="{ menu: false }" @keydown.escape.window="menu = false"
        class="sticky top-0 z-50 border-b border-[#ece9e5] bg-white/85 backdrop-blur-xl">
    <div class="mx-auto max-w-6xl px-6 flex items-center justify-between h-[68px]">
        <a href="/" aria-label="Magewire, go to homepage" class="shrink-0 select-none group flex items-center gap-2.5">
            <img src="/favicon.svg" alt="" width="28" height="28" class="w-7 h-7 rounded-[7px] shadow-sm">
            <span class="text-[18px] font-bold tracking-tight text-[#1d1d1f] group-hover:text-mw-600 transition-colors">MagewirePHP</span>
        </a>

        <nav aria-label="Primary" class="hidden md:flex items-center gap-1">
            <a href="https://docs.magewirephp.nl/?ref=main-website" target="_blank" rel="noopener" class="nav-link">Docs</a>
            <a href="{{ route('features.index') }}" class="nav-link active" aria-current="page">Features</a>
            <a href="{{ url('/') }}#install" class="nav-link">Install</a>
            <a href="{{ url('/') }}#compatibility" class="nav-link">Compatibility</a>
            <a href="{{ url('/') }}#sponsors" class="nav-link">Sponsors</a>
        </nav>

        <div class="flex items-center gap-2 shrink-0">
            <a href="https://github.com/magewirephp/magewire" target="_blank" rel="noopener" aria-label="Magewire on GitHub"
               class="w-9 h-9 flex items-center justify-center rounded-full border border-[#d2d2d7] text-[#52525b] hover:border-mw-500 hover:text-mw-600 transition-colors">
                <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                </svg>
            </a>
            <button @click="menu = !menu" :aria-expanded="menu" aria-controls="feature-mobile-menu"
                    class="md:hidden w-9 h-9 flex items-center justify-center rounded-full border border-[#d2d2d7] text-[#52525b] hover:border-mw-500 hover:text-mw-600 transition-colors"
                    aria-label="Toggle navigation menu">
                <svg x-show="!menu" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
                <svg x-show="menu" x-cloak width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/>
                </svg>
            </button>
        </div>
    </div>

    <nav id="feature-mobile-menu" x-show="menu" x-cloak x-transition.opacity aria-label="Mobile"
         class="md:hidden border-t border-[#e8e5e1] bg-white/95">
        <div class="mx-auto max-w-6xl px-6 py-3 flex flex-col">
            <a href="https://docs.magewirephp.nl/?ref=main-website" target="_blank" rel="noopener" class="py-3 font-medium border-b border-[#f0ece7]">Docs</a>
            <a href="{{ route('features.index') }}" class="py-3 font-semibold text-mw-600 border-b border-[#f0ece7]" aria-current="page">Features</a>
            <a href="{{ url('/') }}#install" class="py-3 font-medium border-b border-[#f0ece7]">Install</a>
            <a href="{{ url('/') }}#compatibility" class="py-3 font-medium border-b border-[#f0ece7]">Compatibility</a>
            <a href="{{ url('/') }}#sponsors" class="py-3 font-medium">Sponsors</a>
        </div>
    </nav>
</header>

<main id="main">
    <section id="compiler" class="relative overflow-hidden px-6 pt-24 pb-28 sm:pt-32 sm:pb-36">
        <div class="absolute inset-0 dot-grid opacity-40" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_70%_55%_at_50%_0%,rgba(242,99,34,0.15),transparent_72%)]" aria-hidden="true"></div>
        <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-b from-transparent to-[#fafaf8]" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-6xl">
            <div class="grid lg:grid-cols-[.9fr_1.1fr] gap-14 lg:gap-20 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-mw-200 bg-white/80 px-3 py-1.5 text-xs font-bold uppercase tracking-[.14em] text-mw-700 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-mw-500"></span>
                        Handpicked feature 01
                    </div>
                    <h1 class="mt-7 text-5xl sm:text-6xl lg:text-7xl font-black tracking-[-.055em] leading-[.98] text-[#181817]">
                        The<br><span class="text-mw-500">Compiler.</span>
                    </h1>
                    <p class="mt-7 text-xl sm:text-2xl font-semibold tracking-tight text-[#343434]">
                        A better way to write PHTML.
                    </p>
                    <p class="mt-4 max-w-xl text-lg leading-relaxed text-[#6e6e73]">
                        Magewire V3 turns expressive directives and safe echo syntax into plain PHP before Magento renders your component.
                        Cleaner templates for you. Familiar output for Magento.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        <a href="https://docs.magewirephp.nl/pages/features/magewire-template-directives.html?ref=main-website"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center gap-2 rounded-full bg-mw-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-mw-300/40 transition-colors hover:bg-mw-600">
                            Read the compiler docs
                            <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M3 8h10m-3-3 3 3-3 3"/></svg>
                        </a>
                        <a href="https://github.com/magewirephp/magewire/tree/main/lib/Magewire/Mechanisms/HandleCompiling"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center gap-2 rounded-full border border-[#d9d6d1] bg-white px-6 py-3.5 text-sm font-bold text-[#3f3f46] transition-colors hover:border-mw-300 hover:text-mw-600">
                            Browse the source
                        </a>
                    </div>
                </div>

                <div x-data="{ view: 'source' }" class="overflow-hidden rounded-3xl border border-[#34343a] bg-[#111318] shadow-2xl shadow-black/25">
                    <div class="flex items-center justify-between border-b border-white/10 bg-[#1b1d23] px-4 sm:px-5">
                        <div class="flex gap-2 py-4" aria-hidden="true">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#ff5f56]"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-[#febc2e]"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-[#28c840]"></span>
                        </div>
                        <div class="flex self-stretch" role="tablist" aria-label="Compiler transformation">
                            <button @click="view = 'source'" :class="view === 'source' ? 'text-white border-mw-500' : 'text-[#7f8490] border-transparent'"
                                    class="border-b-2 px-3 sm:px-4 text-xs font-semibold transition-colors" role="tab" :aria-selected="view === 'source'">Source .phtml</button>
                            <button @click="view = 'compiled'" :class="view === 'compiled' ? 'text-white border-mw-500' : 'text-[#7f8490] border-transparent'"
                                    class="border-b-2 px-3 sm:px-4 text-xs font-semibold transition-colors" role="tab" :aria-selected="view === 'compiled'">Compiled PHP</button>
                        </div>
                    </div>

                    <div class="relative min-h-[390px] sm:min-h-[420px]">
                        <pre x-show="view === 'source'" class="code-scroll overflow-x-auto p-6 sm:p-8 font-mono text-[13px] leading-7 text-[#d7dae0]" aria-label="Magewire source template"><code><span class="text-[#7f8490]">&lt;section class="account"&gt;</span>
    <span class="text-[#c792ea]">&#64;auth</span>
        <span class="text-[#89ddff]">&lt;h2&gt;</span>Hello, <span class="text-[#ffcb6b]">&#123;&#123; $customer-&gt;getFirstname() &#125;&#125;</span><span class="text-[#89ddff]">&lt;/h2&gt;</span>
    <span class="text-[#c792ea]">&#64;endauth</span>

    <span class="text-[#c792ea]">&#64;if</span> <span class="text-[#d7dae0]">($orders-&gt;count())</span>
        <span class="text-[#89ddff]">&lt;ul&gt;</span>
            <span class="text-[#c792ea]">&#64;foreach</span> <span class="text-[#d7dae0]">($orders as $order)</span>
                <span class="text-[#89ddff]">&lt;li&gt;</span>
                    <span class="text-[#ffcb6b]">&#123;&#123; $order-&gt;getIncrementId() &#125;&#125;</span>
                <span class="text-[#89ddff]">&lt;/li&gt;</span>
            <span class="text-[#c792ea]">&#64;endforeach</span>
        <span class="text-[#89ddff]">&lt;/ul&gt;</span>
    <span class="text-[#c792ea]">&#64;endif</span>
<span class="text-[#7f8490]">&lt;/section&gt;</span></code></pre>

                        <pre x-show="view === 'compiled'" x-cloak class="code-scroll overflow-x-auto p-6 sm:p-8 font-mono text-[12px] leading-6 text-[#d7dae0]" aria-label="Compiled PHP template"><code><span class="text-[#7f8490]">&lt;section class="account"&gt;</span>
    <span class="text-[#c792ea]">&lt;?php if</span> ($__magewire-&gt;action(<span class="text-[#c3e88d]">'magento.auth'</span>)
        -&gt;execute(<span class="text-[#c3e88d]">'is_customer'</span>)): <span class="text-[#c792ea]">?&gt;</span>
        <span class="text-[#89ddff]">&lt;h2&gt;</span>Hello,
            <span class="text-[#c792ea]">&lt;?php echo</span> $escaper-&gt;escapeHtml(
                $customer-&gt;getFirstname()
            ) <span class="text-[#c792ea]">?&gt;</span>
        <span class="text-[#89ddff]">&lt;/h2&gt;</span>
    <span class="text-[#c792ea]">&lt;?php endif ?&gt;</span>

    <span class="text-[#c792ea]">&lt;?php if</span> ($orders-&gt;count()): <span class="text-[#c792ea]">?&gt;</span>
        <span class="text-[#7f8490]">&lt;!-- regular compiled PHP --&gt;</span>
    <span class="text-[#c792ea]">&lt;?php endif ?&gt;</span>
<span class="text-[#7f8490]">&lt;/section&gt;</span></code></pre>
                    </div>

                    <div class="flex items-center gap-2 border-t border-white/10 bg-[#17191f] px-5 py-3 text-xs text-[#7f8490]">
                        <svg class="h-4 w-4 text-green-400" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 8 3 3 7-7"/></svg>
                        Existing PHP blocks stay untouched
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-6 pb-28 sm:pb-36">
        <div class="mx-auto max-w-6xl">
            <div class="grid md:grid-cols-3 gap-5">
                <article class="feature-card rounded-2xl border border-[#e7e3de] bg-white p-7">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-mw-50 text-mw-600">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m7 4-5 6 5 6m6-12 5 6-5 6m-1-14L8 18"/></svg>
                    </span>
                    <h2 class="mt-5 text-lg font-bold">Expressive by default</h2>
                    <p class="mt-2 text-sm leading-relaxed text-[#71717a]">Use concise control flow, Magento-aware directives, and Blade-like echo syntax directly inside familiar <code class="text-mw-600">.phtml</code> files.</p>
                </article>

                <article class="feature-card rounded-2xl border border-[#e7e3de] bg-white p-7">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-mw-50 text-mw-600">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 2 3.5 5v4.5c0 4.2 2.8 6.8 6.5 8.5 3.7-1.7 6.5-4.3 6.5-8.5V5L10 2Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m7 10 2 2 4-5"/></svg>
                    </span>
                    <h2 class="mt-5 text-lg font-bold">Safe output, clearly marked</h2>
                    <p class="mt-2 text-sm leading-relaxed text-[#71717a]">Regular <code class="text-mw-600">&#123;&#123; &#125;&#125;</code> output is escaped through Magento's escaper. Raw output remains an explicit choice with <code class="text-mw-600">&#123;!! !!&#125;</code>.</p>
                </article>

                <article class="feature-card rounded-2xl border border-[#e7e3de] bg-white p-7">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-mw-50 text-mw-600">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" d="M3 5h14M3 10h14M3 15h8"/><path stroke-linecap="round" stroke-linejoin="round" d="m14 14 1.5 1.5L18 13"/></svg>
                    </span>
                    <h2 class="mt-5 text-lg font-bold">Compiled only when needed</h2>
                    <p class="mt-2 text-sm leading-relaxed text-[#71717a]">Magewire reuses the generated view until its source template changes, then recompiles automatically for the active Magento area.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="border-y border-[#e9e5e0] bg-white px-6 py-28 sm:py-36">
        <div class="mx-auto max-w-6xl">
            <div class="max-w-2xl">
                <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">From source to storefront</span>
                <h2 class="mt-4 text-4xl sm:text-5xl font-bold tracking-[-.04em]">One small build step.<br>A much cleaner template.</h2>
                <p class="mt-5 text-lg leading-relaxed text-[#71717a]">Compilation sits quietly between your component template and Magento's renderer. Nothing new is shipped to the browser.</p>
            </div>

            <ol class="mt-14 grid md:grid-cols-4 gap-4" aria-label="Compiler process">
                <li class="relative rounded-2xl bg-[#fafaf8] p-6 ring-1 ring-inset ring-[#e9e5e0]">
                    <span class="font-mono text-xs font-bold text-mw-500">01</span>
                    <h3 class="mt-7 font-bold">Read the source</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#71717a]">A Magewire component begins rendering its regular <code>.phtml</code> template.</p>
                </li>
                <li class="relative rounded-2xl bg-[#fafaf8] p-6 ring-1 ring-inset ring-[#e9e5e0]">
                    <span class="font-mono text-xs font-bold text-mw-500">02</span>
                    <h3 class="mt-7 font-bold">Transform the syntax</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#71717a]">The pipeline handles echoes, directives, slots, fragments, Flakes, Flux, and Magewire tags.</p>
                </li>
                <li class="relative rounded-2xl bg-[#fafaf8] p-6 ring-1 ring-inset ring-[#e9e5e0]">
                    <span class="font-mono text-xs font-bold text-mw-500">03</span>
                    <h3 class="mt-7 font-bold">Store plain PHP</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#71717a]">The result is written below <code>var/magewire/views</code>, separated by Magento area and source path.</p>
                </li>
                <li class="relative rounded-2xl bg-[#fafaf8] p-6 ring-1 ring-inset ring-[#e9e5e0]">
                    <span class="font-mono text-xs font-bold text-mw-500">04</span>
                    <h3 class="mt-7 font-bold">Let Magento render</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#71717a]">Magento receives a normal compiled template and renders it through its familiar PHP engine.</p>
                </li>
            </ol>
        </div>
    </section>

    <section class="px-6 py-28 sm:py-36">
        <div class="mx-auto max-w-6xl grid lg:grid-cols-[.9fr_1.1fr] gap-12 lg:gap-20 items-start">
            <div>
                <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">Made to be extended</span>
                <h2 class="mt-4 text-4xl sm:text-5xl font-bold tracking-[-.04em]">Your domain.<br>Your directives.</h2>
                <p class="mt-5 text-lg leading-relaxed text-[#71717a]">Compiler areas work as namespaces. Register an area and its directives through Magento DI, then use readable, project-specific syntax without patching Magewire.</p>

                <div class="mt-8 flex flex-wrap gap-2.5 text-sm font-mono">
                    <span class="rounded-lg border border-[#e2ded8] bg-white px-3 py-2 text-[#52525b]">&#64;auth</span>
                    <span class="rounded-lg border border-[#e2ded8] bg-white px-3 py-2 text-[#52525b]">&#64;escapeUrl</span>
                    <span class="rounded-lg border border-[#e2ded8] bg-white px-3 py-2 text-[#52525b]">&#64;renderChild</span>
                    <span class="rounded-lg border border-mw-200 bg-mw-50 px-3 py-2 text-mw-700">&#64;storeCurrency</span>
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-[#34343a] bg-[#111318] shadow-xl shadow-black/15">
                <div class="flex items-center justify-between border-b border-white/10 bg-[#1b1d23] px-5 py-4">
                    <span class="text-xs font-mono font-medium text-[#9ca3af]">etc/frontend/di.xml</span>
                    <span class="rounded-full bg-mw-500/15 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-mw-300">Custom area</span>
                </div>
                <pre class="code-scroll overflow-x-auto p-6 sm:p-8 font-mono text-[12px] leading-6 text-[#d7dae0]"><code><span class="text-[#89ddff]">&lt;virtualType</span>
    <span class="text-[#c3e88d]">name</span>=<span class="text-[#ffcb6b]">"Vendor\Module\StoreDirectiveArea"</span>
    <span class="text-[#c3e88d]">type</span>=<span class="text-[#ffcb6b]">"Magewirephp\...\DirectiveArea"</span><span class="text-[#89ddff]">&gt;</span>
    <span class="text-[#89ddff]">&lt;arguments&gt;</span>
        <span class="text-[#89ddff]">&lt;argument</span> <span class="text-[#c3e88d]">name</span>=<span class="text-[#ffcb6b]">"directives"</span>
                  <span class="text-[#c3e88d]">xsi:type</span>=<span class="text-[#ffcb6b]">"array"</span><span class="text-[#89ddff]">&gt;</span>
            <span class="text-[#89ddff]">&lt;item</span> <span class="text-[#c3e88d]">name</span>=<span class="text-[#ffcb6b]">"currency"</span>
                  <span class="text-[#c3e88d]">xsi:type</span>=<span class="text-[#ffcb6b]">"object"</span><span class="text-[#89ddff]">&gt;</span>
                Vendor\Module\Directive\Currency
            <span class="text-[#89ddff]">&lt;/item&gt;</span>
        <span class="text-[#89ddff]">&lt;/argument&gt;</span>
    <span class="text-[#89ddff]">&lt;/arguments&gt;</span>
<span class="text-[#89ddff]">&lt;/virtualType&gt;</span></code></pre>
            </div>
        </div>
    </section>

    <section class="px-6 pb-28 sm:pb-36">
        <div class="mx-auto max-w-6xl rounded-3xl bg-[#171716] px-7 py-10 sm:px-12 sm:py-12 text-white">
            <div class="grid md:grid-cols-[1fr_auto] gap-8 items-center">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.14em] text-mw-300">Good to know</p>
                    <h2 class="mt-3 text-2xl sm:text-3xl font-bold tracking-tight">Need a clean slate?</h2>
                    <p class="mt-3 max-w-2xl text-sm sm:text-base leading-relaxed text-[#a9a9ad]">Compiled templates refresh automatically when their source changes. You can also clear every generated Magewire view—or only one Magento area—from the CLI.</p>
                </div>
                <code class="block overflow-x-auto rounded-xl border border-white/10 bg-black/25 px-5 py-4 font-mono text-sm text-[#e5e7eb]">bin/magento <span class="text-mw-300">magewire:compile:clear</span></code>
            </div>
        </div>
    </section>

    <section class="border-t border-[#e9e5e0] bg-white px-6 py-24">
        <div class="mx-auto max-w-6xl text-center">
            <span class="text-xs font-bold uppercase tracking-[.14em] text-[#9ca3af]">Handpicked features</span>
            <h2 class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight">The Compiler is just the beginning.</h2>
            <p class="mx-auto mt-4 max-w-xl text-base leading-relaxed text-[#71717a]">More focused feature stories can join this page as Magewire grows.</p>
            <div class="mt-8 flex justify-center gap-3">
                <span class="inline-flex items-center gap-2 rounded-full bg-mw-50 px-4 py-2 text-sm font-semibold text-mw-700 ring-1 ring-inset ring-mw-200">
                    <span class="h-2 w-2 rounded-full bg-mw-500"></span>
                    01 Compiler
                </span>
                <span class="rounded-full bg-[#f5f3f0] px-4 py-2 text-sm font-medium text-[#9ca3af]">02 Coming next</span>
            </div>
        </div>
    </section>
</main>

<footer class="bg-[#0f0f0e] px-6 py-12">
    <div class="mx-auto max-w-6xl flex flex-col md:flex-row items-center justify-between gap-7">
        <a href="/" class="font-bold text-[#d1d5db] hover:text-white transition-colors">MagewirePHP</a>
        <nav aria-label="Footer" class="flex flex-wrap items-center justify-center gap-6">
            <a href="https://docs.magewirephp.nl/?ref=main-website" target="_blank" rel="noopener" class="text-sm text-[#9ca3af] hover:text-white">Docs</a>
            <a href="{{ route('features.index') }}" class="text-sm text-white">Features</a>
            <a href="https://github.com/magewirephp/magewire" target="_blank" rel="noopener" class="text-sm text-[#9ca3af] hover:text-white">GitHub</a>
            <a href="https://discord.gg/magewire" target="_blank" rel="noopener" class="text-sm text-[#9ca3af] hover:text-white">Discord</a>
        </nav>
        <p class="text-sm text-[#73737a]">MIT License &mdash; &copy; {{ date('Y') }}</p>
    </div>
</footer>

</body>
</html>
