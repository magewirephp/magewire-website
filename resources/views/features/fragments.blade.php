@extends('features.layout')

@section('title', 'Fragments')
@section('description', 'Give rendered PHTML a typed boundary for validation, modifiers, attributes, and Magento-aware Content Security Policy handling.')

@section('content')
<section class="relative overflow-hidden px-6 py-24 sm:py-32">
    <div class="dot-grid absolute inset-0 opacity-40" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_70%_55%_at_35%_0%,rgba(242,99,34,0.16),transparent_72%)]" aria-hidden="true"></div>

    <div class="relative mx-auto grid max-w-6xl items-center gap-14 lg:grid-cols-[.9fr_1.1fr] lg:gap-20">
        <div>
            <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">Magewire feature</span>
            <h1 class="mt-5 text-5xl font-black leading-[.98] tracking-[-.055em] text-mw-500 sm:text-6xl lg:text-7xl">
                Fragments.
            </h1>
            <p class="mt-7 text-xl font-semibold tracking-tight text-[#343434] sm:text-2xl">
                Structured output. Still unmistakably PHTML.
            </p>
            <p class="mt-4 max-w-xl text-lg leading-relaxed text-[#6e6e73]">
                Keep writing ordinary markup. A fragment gives selected output a typed boundary so Magewire can validate,
                enhance, and integrate it with Magento before the response reaches the browser.
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="https://docs.magewirephp.nl/pages/concepts/fragments.html?ref=main-website"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center gap-2 rounded-full bg-mw-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-mw-300/40 transition-colors hover:bg-mw-600">
                    Read the Fragments docs
                    <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M3 8h10m-3-3 3 3-3 3"/></svg>
                </a>
                <a href="https://github.com/magewirephp/magewire/blob/main/src/Model/View/Fragment.php"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center rounded-full border border-[#d9d6d1] bg-white px-6 py-3.5 text-sm font-bold text-[#3f3f46] transition-colors hover:border-mw-300 hover:text-mw-600">
                    Browse the source
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-[#34343a] bg-[#111318] shadow-2xl shadow-black/25">
            <div class="flex items-center justify-between border-b border-white/10 bg-[#1b1d23] px-5 py-4">
                <span class="font-mono text-xs text-[#9ca3af]">checkout.phtml</span>
                <span class="rounded-full bg-mw-500/15 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-mw-300">Script fragment</span>
            </div>
            <pre class="code-scroll overflow-x-auto px-6 py-7 font-mono text-[13px] leading-7 text-[#d7dae0] sm:px-8"><code><span class="text-[#c792ea]">&#64;script</span>
<span class="text-[#89ddff]">&lt;script&gt;</span>
    window.checkoutReady = <span class="text-[#c3e88d]">true</span>
<span class="text-[#89ddff]">&lt;/script&gt;</span>
<span class="text-[#c792ea]">&#64;endscript</span></code></pre>

            <div class="border-t border-white/10 bg-[#17191f] px-5 py-5 sm:px-7">
                <ol class="grid grid-cols-3 gap-2" aria-label="Fragment transformation">
                    <li class="rounded-xl border border-white/10 bg-white/[.03] px-3 py-3 text-center">
                        <span class="block font-mono text-[10px] text-mw-300">01</span>
                        <span class="mt-1 block text-xs font-semibold text-white">Validate</span>
                    </li>
                    <li class="rounded-xl border border-white/10 bg-white/[.03] px-3 py-3 text-center">
                        <span class="block font-mono text-[10px] text-mw-300">02</span>
                        <span class="mt-1 block text-xs font-semibold text-white">Modify</span>
                    </li>
                    <li class="rounded-xl border border-mw-400/30 bg-mw-500/10 px-3 py-3 text-center">
                        <span class="block font-mono text-[10px] text-mw-300">03</span>
                        <span class="mt-1 block text-xs font-semibold text-white">Render</span>
                    </li>
                </ol>
            </div>

            <div class="flex items-center gap-2 border-t border-white/10 bg-[#14161b] px-5 py-3 text-xs text-[#8f939d]">
                <svg class="h-4 w-4 text-green-400" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 8 3 3 7-7"/></svg>
                The template stays readable; the output gains a lifecycle.
            </div>
        </div>
    </div>
</section>

<section class="border-y border-[#e9e5e0] bg-white px-6 py-24 sm:py-28">
    <div class="mx-auto max-w-6xl">
        <div class="max-w-2xl">
            <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">Why it exists</span>
            <h2 class="mt-4 text-4xl font-bold tracking-[-.04em] sm:text-5xl">Some markup needs<br>more than an echo.</h2>
            <p class="mt-5 text-lg leading-relaxed text-[#71717a]">Fragments create one deliberate place for output-aware behavior without moving that complexity into the template.</p>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-3">
            <article class="rounded-2xl border border-[#e7e3de] bg-[#fafaf8] p-7">
                <span class="font-mono text-xs font-bold text-mw-600">01</span>
                <h3 class="mt-5 text-lg font-bold">Give output a type</h3>
                <p class="mt-2 text-sm leading-relaxed text-[#71717a]">Choose HTML, script, style, JavaScript, component, or a custom type with its own output contract.</p>
            </article>
            <article class="rounded-2xl border border-[#e7e3de] bg-[#fafaf8] p-7">
                <span class="font-mono text-xs font-bold text-mw-600">02</span>
                <h3 class="mt-5 text-lg font-bold">Enhance after rendering</h3>
                <p class="mt-2 text-sm leading-relaxed text-[#71717a]">Add root attributes, developer annotations, or DI-registered modifiers once the complete markup is available.</p>
            </article>
            <article class="rounded-2xl border border-[#e7e3de] bg-[#fafaf8] p-7">
                <span class="font-mono text-xs font-bold text-mw-600">03</span>
                <h3 class="mt-5 text-lg font-bold">Work with Magento's context</h3>
                <p class="mt-2 text-sm leading-relaxed text-[#71717a]">Let the same script use a nonce on an uncached request or register a hash when full-page cache is involved.</p>
            </article>
        </div>
    </div>
</section>

<section class="px-6 py-24 sm:py-28">
    <div class="mx-auto max-w-6xl">
        <div class="max-w-2xl">
            <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">How it works</span>
            <h2 class="mt-4 text-4xl font-bold tracking-[-.04em] sm:text-5xl">A controlled pass over finished output.</h2>
            <p class="mt-5 text-lg leading-relaxed text-[#71717a]">Magewire buffers only the marked region, then runs its type-specific pipeline in a predictable order.</p>
        </div>

        <ol class="mt-12 grid gap-4 md:grid-cols-4" aria-label="Fragment lifecycle">
            <li class="rounded-2xl bg-white p-6 ring-1 ring-inset ring-[#e9e5e0]">
                <span class="font-mono text-xs font-bold text-mw-500">01 / START</span>
                <p class="mt-5 text-sm leading-relaxed text-[#52525b]"><code>start()</code> opens a buffer around the selected template region.</p>
            </li>
            <li class="rounded-2xl bg-white p-6 ring-1 ring-inset ring-[#e9e5e0]">
                <span class="font-mono text-xs font-bold text-mw-500">02 / CAPTURE</span>
                <p class="mt-5 text-sm leading-relaxed text-[#52525b]"><code>end()</code> captures the ordinary markup emitted by PHTML.</p>
            </li>
            <li class="rounded-2xl bg-white p-6 ring-1 ring-inset ring-[#e9e5e0]">
                <span class="font-mono text-xs font-bold text-mw-500">03 / PROCESS</span>
                <p class="mt-5 text-sm leading-relaxed text-[#52525b]">Validators run first, followed by registered modifiers in sort order.</p>
            </li>
            <li class="rounded-2xl bg-white p-6 ring-1 ring-inset ring-[#e9e5e0]">
                <span class="font-mono text-xs font-bold text-mw-500">04 / RENDER</span>
                <p class="mt-5 text-sm leading-relaxed text-[#52525b]">The final output is written to the response with its enhancements applied.</p>
            </li>
        </ol>
    </div>
</section>

<section class="bg-[#171716] px-6 py-20 text-white">
    <div class="mx-auto max-w-6xl">
        <div class="max-w-2xl">
            <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-300">Magento CSP integration</span>
            <h2 class="mt-3 text-2xl font-bold tracking-tight sm:text-3xl">One script fragment. Two correct outcomes.</h2>
            <p class="mt-3 leading-relaxed text-[#a9a9ad]">The CSP modifier responds to Magento's caching context, so the template author does not need to branch.</p>
        </div>

        <div class="mt-10 grid gap-5 md:grid-cols-2">
            <article class="rounded-2xl border border-white/10 bg-white/[.04] p-7">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="font-bold">Uncached request</h3>
                    <span class="rounded-full bg-green-400/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-green-300">Nonce</span>
                </div>
                <code class="mt-6 block overflow-x-auto font-mono text-xs text-[#cbd5e1]">&lt;script <span class="text-mw-300">nonce=&quot;...&quot;</span>&gt;</code>
                <p class="mt-4 text-sm leading-relaxed text-[#a9a9b2]">A nonce attribute is applied to the rendered script element.</p>
            </article>
            <article class="rounded-2xl border border-white/10 bg-white/[.04] p-7">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="font-bold">Full-page cache</h3>
                    <span class="rounded-full bg-sky-400/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-sky-300">Hash</span>
                </div>
                <code class="mt-6 block overflow-x-auto font-mono text-xs text-[#cbd5e1]">Content-Security-Policy: <span class="text-sky-300">sha256-...</span></code>
                <p class="mt-4 text-sm leading-relaxed text-[#a9a9b2]">The inline code's hash is registered with Magento's dynamic CSP collector.</p>
            </article>
        </div>
    </div>
</section>
@endsection
