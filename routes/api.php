<?php

use App\Http\Controllers\FrontPropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('properties')->group(function () {
    Route::get('featured', [FrontPropertyController::class, 'featured'])->middleware('throttle:60,1');
    Route::get('search', [FrontPropertyController::class, 'search'])->middleware('throttle:60,1');
    Route::get('options', [FrontPropertyController::class, 'searchOptions'])->middleware('throttle:60,1');
    Route::get('{slug}', [FrontPropertyController::class, 'show'])->middleware('throttle:60,1');
});
