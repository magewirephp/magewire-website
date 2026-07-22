@extends('features.layout')

@section('title', 'The Compiler')
@section('description', 'Use expressive Magewire directives in regular Magento PHTML templates, compiled to plain PHP before Magento renders them.')

@section('content')
<section class="relative overflow-hidden px-6 py-24 sm:py-32">
    <div class="dot-grid absolute inset-0 opacity-40" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_70%_55%_at_35%_0%,rgba(242,99,34,0.16),transparent_72%)]" aria-hidden="true"></div>

    <div class="relative mx-auto grid max-w-6xl items-center gap-14 lg:grid-cols-[.9fr_1.1fr] lg:gap-20">
        <div>
            <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">Magewire feature</span>
            <h1 class="mt-5 text-5xl font-black leading-[.98] tracking-[-.055em] text-[#181817] sm:text-6xl lg:text-7xl">
                The<br><span class="text-mw-500">Compiler.</span>
            </h1>
            <p class="mt-7 text-xl font-semibold tracking-tight text-[#343434] sm:text-2xl">
                Expressive directives. Still unmistakably Magento.
            </p>
            <p class="mt-4 max-w-xl text-lg leading-relaxed text-[#6e6e73]">
                Add concise, readable directives to regular <code class="text-mw-700">.phtml</code> files.
                Magewire turns them into plain PHP before rendering, so Magento keeps receiving the templates it expects.
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="https://docs.magewirephp.nl/pages/features/magewire-template-directives.html?ref=main-website"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center gap-2 rounded-full bg-mw-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-mw-300/40 transition-colors hover:bg-mw-600">
                    Read the compiler docs
                    <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M3 8h10m-3-3 3 3-3 3"/></svg>
                </a>
                <a href="https://github.com/magewirephp/magewire/tree/main/lib/Magewire/Mechanisms/HandleCompiling"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center rounded-full border border-[#d9d6d1] bg-white px-6 py-3.5 text-sm font-bold text-[#3f3f46] transition-colors hover:border-mw-300 hover:text-mw-600">
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
                            class="border-b-2 px-3 text-xs font-semibold transition-colors sm:px-4" role="tab" :aria-selected="view === 'source'">Source .phtml</button>
                    <button @click="view = 'compiled'" :class="view === 'compiled' ? 'text-white border-mw-500' : 'text-[#7f8490] border-transparent'"
                            class="border-b-2 px-3 text-xs font-semibold transition-colors sm:px-4" role="tab" :aria-selected="view === 'compiled'">Compiled PHP</button>
                </div>
            </div>

            <div class="min-h-[330px]">
                <pre x-show="view === 'source'" class="code-scroll overflow-x-auto p-6 font-mono text-[13px] leading-7 text-[#d7dae0] sm:p-8"><code><span class="text-[#7f8490]">&lt;section class="account"&gt;</span>
    <span class="text-[#c792ea]">&#64;auth</span>
        <span class="text-[#89ddff]">&lt;h2&gt;</span>Hello, <span class="text-[#ffcb6b]">&#123;&#123; $customer-&gt;getFirstname() &#125;&#125;</span><span class="text-[#89ddff]">&lt;/h2&gt;</span>
    <span class="text-[#c792ea]">&#64;endauth</span>

    <span class="text-[#c792ea]">&#64;foreach</span> <span class="text-[#d7dae0]">($orders as $order)</span>
        <span class="text-[#89ddff]">&lt;a href="..."&gt;</span>
            <span class="text-[#ffcb6b]">&#123;&#123; $order-&gt;getIncrementId() &#125;&#125;</span>
        <span class="text-[#89ddff]">&lt;/a&gt;</span>
    <span class="text-[#c792ea]">&#64;endforeach</span>
<span class="text-[#7f8490]">&lt;/section&gt;</span></code></pre>

                <pre x-show="view === 'compiled'" x-cloak class="code-scroll overflow-x-auto p-6 font-mono text-[12px] leading-6 text-[#d7dae0] sm:p-8"><code><span class="text-[#7f8490]">&lt;section class="account"&gt;</span>
    <span class="text-[#c792ea]">&lt;?php if</span> ($__magewire-&gt;action(<span class="text-[#c3e88d]">'magento.auth'</span>)
        -&gt;execute(<span class="text-[#c3e88d]">'is_customer'</span>)): <span class="text-[#c792ea]">?&gt;</span>
        <span class="text-[#89ddff]">&lt;h2&gt;</span>Hello,
            <span class="text-[#c792ea]">&lt;?=</span> $escaper-&gt;escapeHtml(
                $customer-&gt;getFirstname()
            ) <span class="text-[#c792ea]">?&gt;</span>
        <span class="text-[#89ddff]">&lt;/h2&gt;</span>
    <span class="text-[#c792ea]">&lt;?php endif ?&gt;</span>

    <span class="text-[#c792ea]">&lt;?php foreach</span> ($orders as $order): <span class="text-[#c792ea]">?&gt;</span>
        <span class="text-[#7f8490]">&lt;!-- familiar PHTML continues --&gt;</span>
    <span class="text-[#c792ea]">&lt;?php endforeach ?&gt;</span>
<span class="text-[#7f8490]">&lt;/section&gt;</span></code></pre>
            </div>

            <div class="flex items-center gap-2 border-t border-white/10 bg-[#17191f] px-5 py-3 text-xs text-[#8f939d]">
                <svg class="h-4 w-4 text-green-400" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 8 3 3 7-7"/></svg>
                Directives become PHP; regular template code stays regular template code.
            </div>
        </div>
    </div>
</section>

<section class="border-y border-[#e9e5e0] bg-white px-6 py-24 sm:py-28">
    <div class="mx-auto max-w-6xl">
        <div class="max-w-2xl">
            <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">Why it exists</span>
            <h2 class="mt-4 text-4xl font-bold tracking-[-.04em] sm:text-5xl">Less template ceremony.<br>Not a new template world.</h2>
            <p class="mt-5 text-lg leading-relaxed text-[#71717a]">The compiler improves the part developers type without replacing the part Magento runs.</p>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-3">
            <article class="rounded-2xl border border-[#e7e3de] bg-[#fafaf8] p-7">
                <span class="font-mono text-xs font-bold text-mw-600">01</span>
                <h3 class="mt-5 text-lg font-bold">Keep PHTML readable</h3>
                <p class="mt-2 text-sm leading-relaxed text-[#71717a]">Use clear control flow and escaped echo syntax without filling a template with repetitive PHP tags.</p>
            </article>
            <article class="rounded-2xl border border-[#e7e3de] bg-[#fafaf8] p-7">
                <span class="font-mono text-xs font-bold text-mw-600">02</span>
                <h3 class="mt-5 text-lg font-bold">Keep Magento in control</h3>
                <p class="mt-2 text-sm leading-relaxed text-[#71717a]">The result is stored as a real <code>.phtml</code> file and handed back to Magento's familiar PHP renderer.</p>
            </article>
            <article class="rounded-2xl border border-[#e7e3de] bg-[#fafaf8] p-7">
                <span class="font-mono text-xs font-bold text-mw-600">03</span>
                <h3 class="mt-5 text-lg font-bold">Shape it around your domain</h3>
                <p class="mt-2 text-sm leading-relaxed text-[#71717a]">Register custom directive areas through Magento DI instead of patching Magewire or introducing template business logic.</p>
            </article>
        </div>
    </div>
</section>

<section class="px-6 py-24 sm:py-28">
    <div class="mx-auto max-w-6xl">
        <div class="max-w-2xl">
            <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-600">How it works</span>
            <h2 class="mt-4 text-4xl font-bold tracking-[-.04em] sm:text-5xl">A quiet step before rendering.</h2>
            <p class="mt-5 text-lg leading-relaxed text-[#71717a]">Compilation happens only when the generated view is missing or its source template has changed.</p>
        </div>

        <ol class="mt-12 grid gap-4 md:grid-cols-4" aria-label="Compiler lifecycle">
            <li class="rounded-2xl bg-white p-6 ring-1 ring-inset ring-[#e9e5e0]">
                <span class="font-mono text-xs font-bold text-mw-500">01 / READ</span>
                <p class="mt-5 text-sm leading-relaxed text-[#52525b]">Magewire receives the component's regular source template.</p>
            </li>
            <li class="rounded-2xl bg-white p-6 ring-1 ring-inset ring-[#e9e5e0]">
                <span class="font-mono text-xs font-bold text-mw-500">02 / COMPILE</span>
                <p class="mt-5 text-sm leading-relaxed text-[#52525b]">Registered directives and echo syntax become minimal PHP.</p>
            </li>
            <li class="rounded-2xl bg-white p-6 ring-1 ring-inset ring-[#e9e5e0]">
                <span class="font-mono text-xs font-bold text-mw-500">03 / STORE</span>
                <p class="mt-5 text-sm leading-relaxed text-[#52525b]">The generated view is cached below <code>var/magewire/views</code>.</p>
            </li>
            <li class="rounded-2xl bg-white p-6 ring-1 ring-inset ring-[#e9e5e0]">
                <span class="font-mono text-xs font-bold text-mw-500">04 / RENDER</span>
                <p class="mt-5 text-sm leading-relaxed text-[#52525b]">Magento renders the compiled <code>.phtml</code> through PHP as usual.</p>
            </li>
        </ol>
    </div>
</section>

<section class="bg-[#171716] px-6 py-20 text-white">
    <div class="mx-auto grid max-w-6xl items-center gap-8 md:grid-cols-[1fr_auto]">
        <div>
            <span class="text-xs font-bold uppercase tracking-[.14em] text-mw-300">Useful when developing</span>
            <h2 class="mt-3 text-2xl font-bold tracking-tight sm:text-3xl">Generated views normally manage themselves.</h2>
            <p class="mt-3 max-w-2xl leading-relaxed text-[#a9a9ad]">When you do need a clean slate, clear every compiled Magewire view, or target one Magento area from the CLI.</p>
        </div>
        <code class="block overflow-x-auto rounded-xl border border-white/10 bg-black/25 px-5 py-4 font-mono text-sm text-[#e5e7eb]">bin/magento <span class="text-mw-300">magewire:compile:clear</span></code>
    </div>
</section>
@endsection
