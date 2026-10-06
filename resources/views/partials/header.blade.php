@php
    $home = request()->path() === '/' ? '' : url('/');
    $headerLinks = [
        ['label' => 'Docs', 'url' => 'https://docs.magewirephp.nl/?ref=main-website', 'external' => true],
        ['label' => 'Why', 'url' => route('why'), 'external' => false],
        ['label' => 'Install', 'url' => $home.'#install', 'external' => false],
        ['label' => 'Compatibility', 'url' => $home.'#compatibility', 'external' => false],
        ['label' => 'Tools', 'url' => $home.'#tools', 'external' => false],
        ['label' => 'Sponsors', 'url' => $home.'#sponsors', 'external' => false],
        ['label' => 'Blog', 'url' => 'https://docs.magewirephp.nl/blogs/?ref=main-website', 'external' => true],
    ];
@endphp

<header id="site-nav" role="banner"
        x-data="{ menu: false }" @keydown.escape.window="if (menu) { menu = false; $refs.menuToggle.focus() }"
        class="nav-glass {{ ($sticky ?? false) ? 'sticky' : 'fixed' }} site-header">
    @if ($notice ?? false)
        <div id="security-notice" class="site-notice" role="region" aria-label="Security notice">
            <div class="site-notice__inner">
                <span class="site-notice__tag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008M9 3.6 3.75 6v5.25c0 4.6 3.4 8.4 8.25 9.75 4.85-1.35 8.25-5.15 8.25-9.75V6L15 3.6a7.5 7.5 0 0 0-6 0Z"/></svg>
                    Security
                </span>
                <p class="site-notice__text">
                    <span class="site-notice__long"><strong>Magewire 3.7.2</strong> fixes a high-severity vulnerability affecting 3.0.0&ndash;3.7.1.</span>
                    <span class="site-notice__short"><strong>3.7.2</strong>: high-severity fix.</span>
                    <a href="https://github.com/magewirephp/magewire/releases/tag/3.7.2" target="_blank" rel="noopener" class="site-notice__link">Upgrade now&nbsp;&rarr;</a>
                </p>
                <button type="button" class="site-notice__dismiss" data-notice-dismiss="3.7.2" aria-label="Dismiss security notice">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
                </button>
            </div>
        </div>
    @endif
    <div class="site-header__bar">
        <a href="/" class="site-header__brand" aria-label="Magewire, go to homepage">MagewirePHP</a>

        <nav aria-label="Primary" class="site-header__nav">
            @foreach ($headerLinks as $link)
                <a href="{{ $link['url'] }}" class="site-header__link"
                   @if ($link['external']) target="_blank" rel="noopener" @endif
                   @if ($link['label'] === 'Why' && request()->routeIs('why')) aria-current="page" @endif>{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="site-header__actions">
            <a href="https://github.com/magewirephp/magewire" target="_blank" rel="noopener"
               class="site-header__icon" aria-label="Magewire on GitHub">
                <svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                </svg>
            </a>
            <a href="https://discord.gg/magewire" target="_blank" rel="noopener"
               class="site-header__icon site-header__discord" aria-label="Discord">
                <svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057c.002.022.015.043.033.055a19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03ZM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418Zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418Z"/>
                </svg>
            </a>
            <button type="button" class="site-header__icon site-header__motion" data-motion-toggle
                    aria-pressed="false" aria-label="Pause background animation" title="Pause background animation" hidden>
                <svg class="site-header__pause" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true"><path d="M2 1h3v10H2zm5 0h3v10H7z"/></svg>
                <svg class="site-header__play" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true"><path d="m3 1 8 5-8 5z"/></svg>
            </button>
            <button type="button" class="site-header__icon site-header__menu-toggle" x-ref="menuToggle"
                    @click="menu = !menu" :aria-expanded="menu" aria-controls="mobile-menu" aria-label="Toggle navigation menu">
                <svg x-show="!menu" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="menu" x-cloak viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
    </div>

    <nav id="mobile-menu" aria-label="Mobile" class="site-header__mobile" x-show="menu" x-cloak
         x-transition.opacity @click.outside="menu = false">
        <div class="site-header__mobile-links">
            @foreach ($headerLinks as $link)
                <a href="{{ $link['url'] }}" class="site-header__link" @click="menu = false"
                   @if ($link['external']) target="_blank" rel="noopener" @endif
                   @if ($link['label'] === 'Why' && request()->routeIs('why')) aria-current="page" @endif>{{ $link['label'] }}</a>
            @endforeach
            <div class="site-header__mobile-community">
                <a href="https://github.com/magewirephp/magewire" target="_blank" rel="noopener" class="site-header__link">GitHub</a>
                <a href="https://discord.gg/magewire" target="_blank" rel="noopener" class="site-header__link">Discord</a>
            </div>
        </div>
    </nav>
</header>
