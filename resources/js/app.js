import Alpine from 'alpinejs';
import '../../public/js/painted-scenes.js';

Alpine.data('siteStats', () => ({
    stars: 254,
    downloads: 1125229,
    fmt(n) {
        if (n >= 1e6) return (n / 1e6).toFixed(1) + 'M';
        if (n >= 1e3) return Math.round(n / 1e3) + 'K';
        return n;
    },
    init() {
        const key = 'magewire:stats:v1';
        try {
            const saved = JSON.parse(localStorage.getItem(key));
            if (saved && Date.now() - saved.savedAt < 3600000 && Number.isFinite(saved.stars) && Number.isFinite(saved.downloads)) {
                this.stars = saved.stars;
                this.downloads = saved.downloads;
                return;
            }
        } catch {}

        const refresh = async () => {
            try {
                const [github, packagist] = await Promise.all([
                    fetch('https://api.github.com/repos/magewirephp/magewire', { signal: AbortSignal.timeout?.(5000) }).then(r => r.ok ? r.json() : Promise.reject()),
                    fetch('https://packagist.org/packages/magewirephp/magewire/stats.json', { signal: AbortSignal.timeout?.(5000) }).then(r => r.ok ? r.json() : Promise.reject()),
                ]);
                if (!Number.isFinite(github.stargazers_count) || !Number.isFinite(packagist.downloads?.total)) return;
                this.stars = github.stargazers_count;
                this.downloads = packagist.downloads.total;
                try { localStorage.setItem(key, JSON.stringify({ stars: this.stars, downloads: this.downloads, savedAt: Date.now() })); } catch {}
            } catch {}
        };
        const schedule = () => {
            if ('requestIdleCallback' in window) requestIdleCallback(refresh, { timeout: 2000 });
            else setTimeout(refresh, 200);
        };
        if (document.readyState === 'complete') schedule();
        else window.addEventListener('load', schedule, { once: true });
    },
}));

Alpine.data('contributorStats', () => ({
    counts: {},
    count(handle, fallback) {
        return this.counts[handle.toLowerCase()] ?? fallback;
    },
    label(handle, fallback) {
        const count = this.count(handle, fallback);
        return `${count} ${count === 1 ? 'contribution' : 'contributions'} to Magewire`;
    },
    init() {
        const key = 'magewire:contributors:v1';
        const validCounts = counts => counts && typeof counts === 'object' && !Array.isArray(counts)
            && Object.values(counts).every(count => Number.isInteger(count) && count >= 0);
        try {
            const saved = JSON.parse(localStorage.getItem(key));
            if (saved && Date.now() - saved.savedAt < 3600000 && validCounts(saved.counts)) {
                this.counts = saved.counts;
                return;
            }
        } catch {}

        const refresh = async () => {
            try {
                const response = await fetch('https://api.github.com/repos/magewirephp/magewire/contributors?per_page=100', { signal: AbortSignal.timeout?.(5000) });
                if (!response.ok) return;
                const contributors = await response.json();
                if (!Array.isArray(contributors)) return;
                const counts = Object.fromEntries(contributors
                    .filter(person => typeof person.login === 'string' && Number.isInteger(person.contributions) && person.contributions >= 0)
                    .map(person => [person.login.toLowerCase(), person.contributions]));
                this.counts = counts;
                try { localStorage.setItem(key, JSON.stringify({ counts, savedAt: Date.now() })); } catch {}
            } catch {}
        };
        const schedule = () => {
            if ('requestIdleCallback' in window) requestIdleCallback(refresh, { timeout: 2000 });
            else setTimeout(refresh, 200);
        };
        if (document.readyState === 'complete') schedule();
        else window.addEventListener('load', schedule, { once: true });
    },
}));

window.Alpine = Alpine;
Alpine.start();
