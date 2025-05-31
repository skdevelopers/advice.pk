<?php

use App\Http\Controllers\FrontPropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('properties')->group(function () {
    // Featured properties for the homepage
    Route::get('featured', [FrontPropertyController::class, 'featured'])->middleware('throttle:60,1');
    // Property search (Buy/Sell/Rent etc, filter via query params)
    Route::get('search', [FrontPropertyController::class, 'search']);

    // Show single property by slug
    Route::get('{slug}', [FrontPropertyController::class, 'show']);
});