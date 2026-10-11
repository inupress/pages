<?php

declare(strict_types=1);

namespace Inupress\Pages;

use Inupress\Contracts\HookRegistry;
use Inupress\Contracts\ProvidesFilament;
use Inupress\Pages\Filament\PagesFilamentPlugin;
use Inupress\Pages\Support\MenuLinkSource;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class PagesServiceProvider extends PackageServiceProvider implements ProvidesFilament
{
    public static string $name = 'inupress-pages';

    public function filamentPlugin(): PagesFilamentPlugin
    {
        return new PagesFilamentPlugin;
    }

    public function packageBooted(): void
    {
        // Pages show up in the menu builder when inupress/menus is installed.
        MenuLinkSource::register($this->app->make(HookRegistry::class));
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name(self::$name)
            ->hasViews()
            ->hasRoute('web')
            ->discoversMigrations()
            ->runsMigrations();
    }
}
