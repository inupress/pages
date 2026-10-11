<?php

declare(strict_types=1);

namespace Inupress\Pages\Support;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Inupress\Contracts\HookRegistry;
use Inupress\Pages\Models\Page;

/**
 * Offers pages to the menu builder of `inupress/menus`, the WordPress way: pages
 * register themselves on the filter the menus plugin owns.
 *
 * The filter name is written out instead of being imported, so this plugin stays free
 * of a dependency on `inupress/menus`. A site without menus simply never runs the code:
 * registering a filter nobody applies costs nothing.
 */
final class MenuLinkSource
{
    /** Owned by inupress/menus: the name lives in its README and as LinkSources::FILTER. */
    public const FILTER = 'menus.link_sources';

    public static function register(HookRegistry $hooks): void
    {
        $hooks->addFilter(self::FILTER, static function (array $sources): array {
            if (! Schema::hasTable((new Page)->getTable())) {
                return $sources; // installed but not migrated: nothing to offer
            }

            $sources['pages'] = [
                'label' => 'Page',
                'options' => Page::query()
                    ->orderBy('title')
                    ->get()
                    ->mapWithKeys(fn (Page $page): array => [
                        $page->id => $page->isPublished() ? $page->title : $page->title.' (unpublished)',
                    ])
                    ->all(),
                // Null hides the item: an unpublished or deleted page leaves no dead link.
                'resolve' => static function (int $id): ?string {
                    $page = Page::query()->find($id);

                    if ($page === null || ! $page->isPublished()) {
                        return null;
                    }

                    return Route::has('pages.show') ? route('pages.show', ['page' => $page]) : null;
                },
            ];

            return $sources;
        });
    }
}
