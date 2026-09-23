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

Open the URL printed by `artisan serve`. The site's CSS and Alpine.js load
from CDNs; an internet connection is needed to inspect their appearance and
browser behavior locally.

## Edit the content

- `resources/views/welcome.blade.php` contains the homepage, install steps,
  examples, and compatibility cards.
- `resources/views/why.blade.php` explains the project's purpose and tradeoffs.
- `resources/views/features/` contains the Compiler and Fragments pages.
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
