<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news');
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('parse', [\App\Http\Controllers\NewsController::class, 'parse'])->name('parse');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
