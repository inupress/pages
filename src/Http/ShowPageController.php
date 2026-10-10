<?php

declare(strict_types=1);

namespace Inupress\Pages\Http;

use Illuminate\Contracts\View\View;
use Inupress\Contracts\HookRegistry;
use Inupress\Contracts\Hooks;
use Inupress\Pages\Models\Page;

final class ShowPageController
{
    public function __invoke(Page $page, HookRegistry $hooks): View
    {
        abort_unless($page->isPublished(), 404);

        // The body is trusted admin HTML; other plugins may wrap it through the public filter.
        $html = (string) $hooks->applyFilters(Hooks::CONTENT_RENDER, $page->body, $page);

        return view('inupress-pages::page', ['page' => $page, 'html' => $html]);
    }
}
