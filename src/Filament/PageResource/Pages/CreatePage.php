<?php

declare(strict_types=1);

namespace Inupress\Pages\Filament\PageResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Inupress\Pages\Filament\PageResource;

final class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;
}
