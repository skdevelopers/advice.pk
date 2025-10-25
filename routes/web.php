<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SocietyController;
use App\Http\Controllers\Admin\SocietyPageController;
use App\Http\Controllers\Admin\SubSectorController;
use App\Http\Controllers\Admin\SubSocietyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EventbriteAuthController;
use App\Http\Controllers\FrontPropertyController;
use App\Services\AiService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('front.home');
});
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

Route::get('/chat', [ChatController::class, 'index'])->name('chat');
Route::get('/settings', [SettingsController::class, 'index'])
    ->name('settings');

Route::get('properties/{slug}', [FrontPropertyController::class, 'show'])
    ->name('properties.show');
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::post('/ai/generate/seo', function (\Illuminate\Http\Request $request) {
    return app(AiService::class)->generate($request->title, $request->city);
})->name('ai.generate.seo');

// Public Event Brite OAuth routes (no auth middleware)
Route::get('/auth/eventbrite/redirect', [EventbriteAuthController::class, 'redirect'])
    ->name('oauth.eventbrite.redirect');

Route::get('/auth/eventbrite/callback', [EventbriteAuthController::class, 'callback'])
    ->name('oauth.eventbrite.callback');

// Admin Routes - No Auth Middleware for now
Route::prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard.index'); // resources/views/admin/dashboard/index.blade.php
    })->name('admin.dashboard');

    Route::resource('blogs', BlogController::class)->names([
        'index'   => 'admin.blogs.index',
        'create'  => 'admin.blogs.create',
        'store'   => 'admin.blogs.store',
        'show'    => 'admin.blogs.show',
        'edit'    => 'admin.blogs.edit',
        'update'  => 'admin.blogs.update',
        'destroy' => 'admin.blogs.remove',
    ]);

// Soft‐delete restore endpoint
    Route::post('blogs/{id}/restore', [BlogController::class, 'restore'])
        ->name('admin.blogs.restore');

    Route::resource('/societies', SocietyController::class)->names([
        'index'   => 'admin.societies.index',
        'create'  => 'admin.societies.create',
        'store'   => 'admin.societies.store',
        'show'    => 'admin.societies.view',
        'edit'    => 'admin.societies.edit',
        'update'  => 'admin.societies.update',
        'destroy' => 'admin.societies.remove',
    ]);
    Route::post('societies/{id}/restore', [SocietyController::class, 'restore'])->name('admin.societies.restore');

    Route::resource('subsocieties', SubSocietyController::class)->names([
        'index'   => 'admin.subsocieties.index',
        'create'  => 'admin.subsocieties.create',
        'store'   => 'admin.subsocieties.store',
        'show'    => 'admin.subsocieties.view',
        'edit'    => 'admin.subsocieties.edit',
        'update'  => 'admin.subsocieties.update',
        'destroy' => 'admin.subsocieties.remove',
    ]);
    Route::post('subsocieties/{id}/restore', [SubSocietyController::class, 'restore'])->name('admin.subsocieties.restore');

    Route::resource('subsectors', SubSectorController::class)->names([
        'index'   => 'admin.subsectors.index',
        'create'  => 'admin.subsectors.create',
        'store'   => 'admin.subsectors.store',
        'show'    => 'admin.subsectors.show',
        'edit'    => 'admin.subsectors.edit',
        'update'  => 'admin.subsectors.update',
        'destroy' => 'admin.subsectors.destroy',
    ]);
    Route::post('subsectors/{id}/restore', [SubSectorController::class, 'restore'])->name('admin.subsectors.restore');
    // For AJAX dependent dropdown
    Route::get('societies/{society}/subsectors', [SubSectorController::class, 'getForSociety'])->name('admin.societies.subsectors');

    Route::resource('properties', PropertyController::class)->names([
        'index'   => 'admin.properties.index',
        'create'  => 'admin.properties.create',
        'store'   => 'admin.properties.store',
        'show'    => 'admin.properties.show',
        'edit'    => 'admin.properties.edit',
        'update'  => 'admin.properties.update',
        'destroy' => 'admin.properties.destroy',
    ]);
    Route::get('properties/getSubsectors/{society}',
        [PropertyController::class, 'getSubsectors'])
        ->name('admin.properties.getSubsectors');
    Route::get('properties/blocks/{subsector}',
        [PropertyController::class, 'getBlocks'])
        ->name('admin.properties.blocks');

    Route::resource('projects', ProjectController::class)->names([
        'index'   => 'admin.projects.index',
        'create'  => 'admin.projects.create',
        'store'   => 'admin.projects.store',
        'show'    => 'admin.projects.show',
        'edit'    => 'admin.projects.edit',
        'update'  => 'admin.projects.update',
        'destroy' => 'admin.projects.remove',
    ]);

    Route::post('projects/{id}/restore', [ProjectController::class, 'restore'])
        ->name('admin.projects.restore');

    Route::resource('society-pages', SocietyPageController::class)->names([
        'index'   => 'admin.society-pages.index',
        'create'  => 'admin.society-pages.create',
        'store'   => 'admin.society-pages.store',
        'show'    => 'admin.society-pages.show',
        'edit'    => 'admin.society-pages.edit',
        'update'  => 'admin.society-pages.update',
        'destroy' => 'admin.society-pages.destroy',
    ]);

    Route::resource('cities', CityController::class)->names([
        'index'   => 'admin.cities.index',
        'create'  => 'admin.cities.create',
        'store'   => 'admin.cities.store',
        'show'    => 'admin.cities.view',
        'edit'    => 'admin.cities.edit',
        'update'  => 'admin.cities.update',
        'destroy' => 'admin.cities.remove',
    ]);

    Route::get('/users', function () {
        return view('admin.users'); // resources/views/admin/users.blade.php
    })->name('admin.users');

    Route::get('/settings', function () {
        return view('admin.settings'); // resources/views/admin/settings.blade.php
    })->name('admin.settings');

    // Add more as needed for your blade structure
});

