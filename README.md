# Magewire website

This repository contains the public [Magewire website](https://magewirephp.nl/).
It is a Laravel application with Blade pages for the homepage, project story,
and feature highlights. The [Magewire documentation](https://docs.magewirephp.nl/)
is maintained separately in [`magewirephp/magewire-docs`](https://github.com/magewirephp/magewire-docs).

## Work locally

The application requires PHP 8.2 or newer and Composer. Its dependencies
include Flux Pro from `composer.fluxui.dev`, so Composer needs access to that
repository before installation.

```shell
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Open the URL printed by `artisan serve`. The public pages use one local
Alpine.js bundle, a compiled stylesheet, and self-hosted fonts. No frontend
CDN or Livewire/Flux runtime is needed for these static pages.

## Build frontend assets

Node.js 20.19+ and npm are needed when changing templates, scripts, styles,
or `tailwind.config.js`:

```shell
npm ci
npm run build
```

Run `npm run dev` to rebuild as you edit. The build combines Tailwind and the
shared styles, bundles Alpine with the scene controls, and writes content hashes
to `public/asset-manifest.json`. It also creates gzip and Brotli copies of both
bundles. Commit the manifest, `public/css/app.css*`, and `public/js/app.js*` with
source changes so PHP-only deployments have the production assets. Changed
assets receive new URLs, so browsers can cache them safely.

Run `npm run images:build` after adding or changing painted artwork. The image
pipeline retains each original WebP and creates high-quality responsive variants,
with AVIF only when every size is smaller than its WebP equivalent. Update the
image specifications and use `<x-responsive-image>` with `sizes` matching the
rendered layout. The widest candidate preserves the original resolution on
high-density screens. Commit `public/images/responsive/` with image changes.

Contributor portraits and organization logos are cached locally in
`public/images/identity/`. Raster files use lossless WebP only when it is smaller;
otherwise the downloaded original is retained. Run `npm run images:refresh-identities`
and `npm run build` to refresh these public images,
then commit the new files and manifests. Refresh them when updating the
contributor list or when a portrait or organization logo changes.

Font files and their OFL licenses live in `public/fonts/`. The files are the same
Latin subsets previously served by Bunny Fonts, preserving the typography.

## Production performance

Use `APP_ENV=production` and `APP_DEBUG=false`, then run:

```shell
composer install --no-dev --optimize-autoloader
php artisan optimize
```

Public GET pages carry a five-minute public cache policy and ETags, without
creating visitor sessions or cookies. Only these content routes bypass web
session middleware; Livewire's own endpoints retain their middleware.

Apache's `public/.htaccess` serves the precompressed bundles, compresses HTML
when `mod_deflate` is enabled, and gives versioned images, fonts, and bundles
one-year immutable caching. On Nginx, configure HTML/SVG compression and the same
static cache policy at the server; enable `gzip_static on` for the supplied gzip
files, and `brotli_static on` if the Brotli module is installed. Exclude PHP and
HTML from the one-year cache policy. See the official [Nginx gzip static
documentation](https://nginx.org/en/docs/http/ngx_http_gzip_static_module.html).

Repository stars, contributor commit counts, and download counts refresh after
page load using the GitHub and Packagist APIs, with a one-hour browser cache.
Network failures retain the displayed fallback counts. Contributor fallbacks
are maintained alongside the people listed in `resources/views/welcome.blade.php`.

## Edit the content

- `resources/views/welcome.blade.php` contains the homepage, install steps,
  examples, and compatibility cards.
- `resources/views/why.blade.php` explains the project's purpose and tradeoffs.
- `resources/views/features/` contains the Compiler and Fragments pages.
- `public/css/painted-ui.css` defines the shared paper surfaces, card frames,
  and heading accents, using the brush masks in `public/images/ui/`.
- `routes/web.php` defines public URLs and redirects.

Keep code examples aligned with the current
[Magewire V3 guides](https://docs.magewirephp.nl/) and
[core source](https://github.com/magewirephp/magewire). Link changing platform
version details to the
[production-build matrix](https://github.com/magewirephp/magewire/blob/main/.github/workflows/production-build.yml)
instead of copying a snapshot into website copy.

## Check changes

```shell
php artisan view:cache
php artisan test
```

Feature tests cover public pages, links, and key compatibility copy. Review
the rendered pages at desktop and mobile sizes when changing layout or code
examples.
