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

Open the URL printed by `artisan serve`. Tailwind CSS is compiled into
`public/css/app.css`, and Livewire serves the site's single Alpine.js runtime
locally. Fonts load from Bunny Fonts.

## Build the styles

Node.js and npm are needed when changing Tailwind utility classes or
`tailwind.config.js`:

```shell
npm ci
npm run build
```

Run `npm run dev` to rebuild styles as you edit. Commit the generated
`public/css/app.css` with template and configuration changes so PHP-only
deployments have the production stylesheet without running a Node.js build.
The stylesheet URL changes when the generated file is updated.

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
