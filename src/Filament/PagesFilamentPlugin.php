<?php

declare(strict_types=1);

namespace Inupress\Pages\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;

final class PagesFilamentPlugin implements Plugin
{
    public function getId(): string
    {
        return 'inupress-pages';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([PageResource::class]);
    }

    public function boot(Panel $panel): void {}
}
