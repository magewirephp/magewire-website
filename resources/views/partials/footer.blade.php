<footer id="site-footer" class="painted-footer" data-painted-scene>
    <div class="painted-footer__scene" aria-hidden="true">
        <img class="painted-footer__landscape" src="/images/footer/landscape.webp" alt=""
             width="2172" height="724" loading="lazy" decoding="async">
        <img class="painted-footer__cloud painted-footer__cloud--left" src="/images/footer/cloud.webp" alt="" data-scene-animated
             width="1024" height="342" loading="lazy" decoding="async">
        <img class="painted-footer__cloud painted-footer__cloud--right" src="/images/footer/cloud.webp" alt="" data-scene-animated
             width="1024" height="342" loading="lazy" decoding="async">
        <img class="painted-footer__grass painted-footer__grass--left" src="/images/footer/foliage.webp" alt=""
             width="600" height="600" loading="lazy" decoding="async" data-scene-animated>
        <img class="painted-footer__grass painted-footer__grass--right" src="/images/footer/foliage.webp" alt=""
             width="600" height="600" loading="lazy" decoding="async" data-scene-animated>

        @foreach ([
            ['left' => '12%', 'top' => '78%', 'duration' => '3.8s', 'delay' => '-1s'],
            ['left' => '22%', 'top' => '86%', 'duration' => '4.6s', 'delay' => '-3s'],
            ['left' => '38%', 'top' => '81%', 'duration' => '5.2s', 'delay' => '-2s'],
            ['left' => '63%', 'top' => '88%', 'duration' => '4.2s', 'delay' => '-1.8s'],
            ['left' => '78%', 'top' => '76%', 'duration' => '4.8s', 'delay' => '-3.5s'],
            ['left' => '89%', 'top' => '84%', 'duration' => '3.6s', 'delay' => '-.5s'],
        ] as $firefly)
            <span class="painted-footer__firefly" data-scene-animated
                  style="--firefly-left: {{ $firefly['left'] }}; --firefly-top: {{ $firefly['top'] }}; --firefly-duration: {{ $firefly['duration'] }}; --firefly-delay: {{ $firefly['delay'] }};"></span>
        @endforeach
        <div class="painted-footer__veil"></div>
    </div>

    <div class="painted-footer__content">
        <p class="painted-footer__eyebrow">Built by the community</p>
        <a href="/" class="painted-footer__brand" aria-label="MagewirePHP, go to homepage">MagewirePHP</a>
        <p class="painted-footer__description">Reactive Magento, PHP-first.</p>

        <nav aria-label="Footer" class="painted-footer__nav">
            @php
                $footerLinks = [
                    ['label' => 'Docs', 'url' => 'https://docs.magewirephp.nl/?ref=main-website', 'external' => true],
                    ['label' => 'Why', 'url' => route('why'), 'external' => false],
                    ['label' => 'Blog', 'url' => 'https://docs.magewirephp.nl/blogs/?ref=main-website', 'external' => true],
                    ['label' => 'GitHub', 'url' => 'https://github.com/magewirephp/magewire', 'external' => true],
                    ['label' => 'Sponsors', 'url' => 'https://github.com/sponsors/wpoortman', 'external' => true],
                    ['label' => 'Discord', 'url' => 'https://discord.gg/magewire', 'external' => true],
                ];
            @endphp
            @foreach ($footerLinks as $link)
                <a href="{{ $link['url'] }}"
                   @if ($link['external']) target="_blank" rel="noopener" @endif
                   class="painted-footer__link">
                    {{ $link['label'] }}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        @if ($link['external'])
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M7 7h10v10"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/>
                        @endif
                    </svg>
                </a>
            @endforeach
        </nav>
    </div>

    <div class="painted-footer__meta">
        <button type="button" class="painted-footer__motion" aria-pressed="false"
                aria-label="Pause background animation" data-motion-toggle hidden>
            <svg class="painted-footer__pause" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true">
                <path d="M2 1h3v10H2zm5 0h3v10H7z"/>
            </svg>
            <svg class="painted-footer__play" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true">
                <path d="m3 1 8 5-8 5z"/>
            </svg>
            <span data-motion-label>Pause animation</span>
        </button>
        <p>MIT License &middot; &copy; {{ date('Y') }} MagewirePHP</p>
    </div>
</footer>

<script src="/js/painted-scenes.js" defer></script>
