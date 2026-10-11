<?php

declare(strict_types=1);

namespace Inupress\Pages\Support;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Inupress\Contracts\HookRegistry;
use Inupress\Pages\Models\Page;

/**
 * Offers the published pages to the sitemap of `inupress/seo`, the WordPress way: pages
 * register themselves on the filter the seo plugin owns.
 *
 * The filter name is written out instead of being imported, so this plugin stays free of a
 * dependency on `inupress/seo`. A site without seo never runs the code: registering a
 * filter nobody applies costs nothing.
 */
final class SeoUrlSource
{
    /** Owned by inupress/seo: the name lives in its README and as UrlSources::FILTER. */
    public const FILTER = 'seo.urls';

    public static function register(HookRegistry $hooks): void
    {
        $hooks->addFilter(self::FILTER, static function (array $urls): array {
            // Installed but not migrated, or served without routes: nothing to offer.
            if (! Schema::hasTable((new Page)->getTable()) || ! Route::has('pages.show')) {
                return $urls;
            }

            foreach (Page::query()->orderBy('slug')->get() as $page) {
                // A draft or a future publication is not in the site yet, so it is not in
                // the sitemap either; the page itself answers 404 for the same reason.
                if (! $page->isPublished()) {
                    continue;
                }

                $urls[] = [
                    'url' => route('pages.show', ['page' => $page]),
                    'lastmod' => $page->updated_at,
                ];
            }

            return $urls;
        });
    }
}
