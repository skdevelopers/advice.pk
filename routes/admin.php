<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'auth:admin']) // add your custom middleware here
->prefix('admin')                     // or leave prefix out if not needed
->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Add more admin routes here
    });


Route::prefix('admin')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Products management
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // Additional routes for other admin sections can go here
});