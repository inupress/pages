# inupress/pages

Static pages for the Inupress CMS: an admin resource and a public route.

This package is developed in the `inupress/framework` monorepo (`packages/pages`). Report issues and send changes there.

## Install

```bash
composer require inupress/pages
php artisan migrate
```

The plugin is found and its admin resource appears in the panel on its own. Remove it with `composer remove inupress/pages`; the `pages_pages` table is kept.

## What you get

- **Admin:** a **Pages** resource with title, slug, excerpt, rich-text body, status (draft or published) and an optional publish date.
- **Site:** `GET /pages/{slug}` shows a published page. Drafts, pages scheduled for the future and unknown slugs return 404.
- **Hook:** the body passes through the `content.render` filter before it is printed, so other plugins can change the HTML.

The page body is printed as trusted HTML. Only give editing access to people you trust until roles and sanitizing exist.

## Reference

This is the reference plugin with a model, a migration, an admin resource and a route. Read it together with the plugin guide in the monorepo (`docs/plugin-development.md`).

## Requirements

`inupress/core` 0.1, Filament 5, PHP 8.3 or newer.

## License

MIT
