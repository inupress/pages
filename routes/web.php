<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inupress\Pages\Http\ShowPageController;

// Package routes have no middleware group by default. "web" brings sessions, cookies and
// SubstituteBindings, which resolves {page:slug} to the model.
Route::middleware('web')->group(function (): void {
    Route::get('/pages/{page:slug}', ShowPageController::class)->name('pages.show');
});
