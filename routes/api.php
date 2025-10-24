<?php

use App\Http\Controllers\Auth\EventbriteAuthController;
use App\Http\Controllers\FrontPropertyController;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// POST endpoint for Eventbrite webhooks (no CSRF on api.php)
Route::post('/webhooks/eventbrite', EventbriteWebhookController::class)
    ->name('webhooks.eventbrite');

// Group all “properties/…” routes under one prefix:
Route::prefix('properties')->group(function () {
    // 1. GET /properties/featured
    Route::get('featured', [FrontPropertyController::class, 'featured'])
        ->middleware('throttle:60,1')
        ->name('properties.featured');

    // 2. GET /properties/search
    Route::get('search', [FrontPropertyController::class, 'search'])
        ->middleware('throttle:60,1')
        ->name('properties.search');

    // 3. GET /properties/options
    Route::get('options', [FrontPropertyController::class, 'searchOptions'])
        ->middleware('throttle:60,1')
        ->name('properties.options');

    // 4. GET /properties/{slug} → show a single property
    //    (Placed last so “featured”, “search” and “options” are matched first)
    Route::get('{slug}', [FrontPropertyController::class, 'show'])
        ->middleware('throttle:60,1')
        ->name('property.show');
});
