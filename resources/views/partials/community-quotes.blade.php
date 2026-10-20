@php($quotes = config('testimonials.quotes', []))

@if ($quotes)
    <section id="community-quotes" aria-labelledby="community-quotes-title"
             class="painted-section painted-section--paper painted-section--after-paper px-6 py-24 sm:py-32">
        <div class="mx-auto max-w-5xl">
            <div class="mb-12 text-center sm:mb-16">
                <span class="eyebrow">From the community</span>
                <h2 id="community-quotes-title"
                    class="painted-title mx-auto max-w-3xl text-4xl font-bold tracking-tight text-[#1a1a1a] sm:text-5xl">
                    What people say
                </h2>
                <p class="mx-auto mt-4 max-w-xl text-lg leading-relaxed text-[#71717a]">
                    Thoughts from developers using Magewire.
                </p>
            </div>

            <div @class([
                'grid gap-6',
                'mx-auto max-w-2xl' => count($quotes) === 1,
                'md:grid-cols-2' => count($quotes) >= 2,
                'lg:grid-cols-3' => count($quotes) >= 3,
            ])>
                @foreach ($quotes as $quote)
                    <figure class="painted-card flex h-full min-w-0 flex-col p-8 sm:p-10">
                        <span aria-hidden="true" class="mb-2 block h-12 text-6xl font-bold leading-none text-mw-200">“</span>
                        <blockquote @if ($quote['source'] ?? null) cite="{{ $quote['source'] }}" @endif
                                    class="flex-1 text-lg font-medium leading-relaxed text-[#1a1a1a] [overflow-wrap:anywhere]">
                            <p>{{ $quote['quote'] }}</p>
                        </blockquote>
                        <figcaption class="mt-8 border-t border-[#e8e5e1] pt-5">
                            <p class="font-semibold text-[#1d1d1f]">{{ $quote['name'] }}</p>
                            @if ($quote['role'] ?? null)
                                <p class="mt-1 text-sm leading-relaxed text-[#71717a]">{{ $quote['role'] }}</p>
                            @endif
                            @if ($quote['source'] ?? null)
                                <a href="{{ $quote['source'] }}" target="_blank" rel="noopener noreferrer"
                                   class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-mw-600 underline-offset-4 hover:underline focus-visible:underline">
                                    Read the original<span class="sr-only"> quote from {{ $quote['name'] }}</span>
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 4h10v10M16 4 4 16" />
                                    </svg>
                                </a>
                            @endif
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
@endif
